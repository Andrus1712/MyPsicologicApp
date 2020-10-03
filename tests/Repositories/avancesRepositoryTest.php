<?php namespace Tests\Repositories;

use App\Models\avances;
use App\Repositories\avancesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class avancesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var avancesRepository
     */
    protected $avancesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->avancesRepo = \App::make(avancesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_avances()
    {
        $avances = factory(avances::class)->make()->toArray();

        $createdavances = $this->avancesRepo->create($avances);

        $createdavances = $createdavances->toArray();
        $this->assertArrayHasKey('id', $createdavances);
        $this->assertNotNull($createdavances['id'], 'Created avances must have id specified');
        $this->assertNotNull(avances::find($createdavances['id']), 'avances with given id must be in DB');
        $this->assertModelData($avances, $createdavances);
    }

    /**
     * @test read
     */
    public function test_read_avances()
    {
        $avances = factory(avances::class)->create();

        $dbavances = $this->avancesRepo->find($avances->id);

        $dbavances = $dbavances->toArray();
        $this->assertModelData($avances->toArray(), $dbavances);
    }

    /**
     * @test update
     */
    public function test_update_avances()
    {
        $avances = factory(avances::class)->create();
        $fakeavances = factory(avances::class)->make()->toArray();

        $updatedavances = $this->avancesRepo->update($fakeavances, $avances->id);

        $this->assertModelData($fakeavances, $updatedavances->toArray());
        $dbavances = $this->avancesRepo->find($avances->id);
        $this->assertModelData($fakeavances, $dbavances->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_avances()
    {
        $avances = factory(avances::class)->create();

        $resp = $this->avancesRepo->delete($avances->id);

        $this->assertTrue($resp);
        $this->assertNull(avances::find($avances->id), 'avances should not exist in DB');
    }
}
