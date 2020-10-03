<?php namespace Tests\Repositories;

use App\Models\psicologos;
use App\Repositories\psicologosRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class psicologosRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var psicologosRepository
     */
    protected $psicologosRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->psicologosRepo = \App::make(psicologosRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_psicologos()
    {
        $psicologos = factory(psicologos::class)->make()->toArray();

        $createdpsicologos = $this->psicologosRepo->create($psicologos);

        $createdpsicologos = $createdpsicologos->toArray();
        $this->assertArrayHasKey('id', $createdpsicologos);
        $this->assertNotNull($createdpsicologos['id'], 'Created psicologos must have id specified');
        $this->assertNotNull(psicologos::find($createdpsicologos['id']), 'psicologos with given id must be in DB');
        $this->assertModelData($psicologos, $createdpsicologos);
    }

    /**
     * @test read
     */
    public function test_read_psicologos()
    {
        $psicologos = factory(psicologos::class)->create();

        $dbpsicologos = $this->psicologosRepo->find($psicologos->id);

        $dbpsicologos = $dbpsicologos->toArray();
        $this->assertModelData($psicologos->toArray(), $dbpsicologos);
    }

    /**
     * @test update
     */
    public function test_update_psicologos()
    {
        $psicologos = factory(psicologos::class)->create();
        $fakepsicologos = factory(psicologos::class)->make()->toArray();

        $updatedpsicologos = $this->psicologosRepo->update($fakepsicologos, $psicologos->id);

        $this->assertModelData($fakepsicologos, $updatedpsicologos->toArray());
        $dbpsicologos = $this->psicologosRepo->find($psicologos->id);
        $this->assertModelData($fakepsicologos, $dbpsicologos->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_psicologos()
    {
        $psicologos = factory(psicologos::class)->create();

        $resp = $this->psicologosRepo->delete($psicologos->id);

        $this->assertTrue($resp);
        $this->assertNull(psicologos::find($psicologos->id), 'psicologos should not exist in DB');
    }
}
