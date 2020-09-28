<?php namespace Tests\Repositories;

use App\Models\psicologo;
use App\Repositories\psicologoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class psicologoRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var psicologoRepository
     */
    protected $psicologoRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->psicologoRepo = \App::make(psicologoRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_psicologo()
    {
        $psicologo = factory(psicologo::class)->make()->toArray();

        $createdpsicologo = $this->psicologoRepo->create($psicologo);

        $createdpsicologo = $createdpsicologo->toArray();
        $this->assertArrayHasKey('id', $createdpsicologo);
        $this->assertNotNull($createdpsicologo['id'], 'Created psicologo must have id specified');
        $this->assertNotNull(psicologo::find($createdpsicologo['id']), 'psicologo with given id must be in DB');
        $this->assertModelData($psicologo, $createdpsicologo);
    }

    /**
     * @test read
     */
    public function test_read_psicologo()
    {
        $psicologo = factory(psicologo::class)->create();

        $dbpsicologo = $this->psicologoRepo->find($psicologo->id);

        $dbpsicologo = $dbpsicologo->toArray();
        $this->assertModelData($psicologo->toArray(), $dbpsicologo);
    }

    /**
     * @test update
     */
    public function test_update_psicologo()
    {
        $psicologo = factory(psicologo::class)->create();
        $fakepsicologo = factory(psicologo::class)->make()->toArray();

        $updatedpsicologo = $this->psicologoRepo->update($fakepsicologo, $psicologo->id);

        $this->assertModelData($fakepsicologo, $updatedpsicologo->toArray());
        $dbpsicologo = $this->psicologoRepo->find($psicologo->id);
        $this->assertModelData($fakepsicologo, $dbpsicologo->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_psicologo()
    {
        $psicologo = factory(psicologo::class)->create();

        $resp = $this->psicologoRepo->delete($psicologo->id);

        $this->assertTrue($resp);
        $this->assertNull(psicologo::find($psicologo->id), 'psicologo should not exist in DB');
    }
}
