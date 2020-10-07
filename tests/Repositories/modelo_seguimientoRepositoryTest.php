<?php namespace Tests\Repositories;

use App\Models\modelo_seguimiento;
use App\Repositories\modelo_seguimientoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class modelo_seguimientoRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var modelo_seguimientoRepository
     */
    protected $modeloSeguimientoRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->modeloSeguimientoRepo = \App::make(modelo_seguimientoRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_modelo_seguimiento()
    {
        $modeloSeguimiento = factory(modelo_seguimiento::class)->make()->toArray();

        $createdmodelo_seguimiento = $this->modeloSeguimientoRepo->create($modeloSeguimiento);

        $createdmodelo_seguimiento = $createdmodelo_seguimiento->toArray();
        $this->assertArrayHasKey('id', $createdmodelo_seguimiento);
        $this->assertNotNull($createdmodelo_seguimiento['id'], 'Created modelo_seguimiento must have id specified');
        $this->assertNotNull(modelo_seguimiento::find($createdmodelo_seguimiento['id']), 'modelo_seguimiento with given id must be in DB');
        $this->assertModelData($modeloSeguimiento, $createdmodelo_seguimiento);
    }

    /**
     * @test read
     */
    public function test_read_modelo_seguimiento()
    {
        $modeloSeguimiento = factory(modelo_seguimiento::class)->create();

        $dbmodelo_seguimiento = $this->modeloSeguimientoRepo->find($modeloSeguimiento->id);

        $dbmodelo_seguimiento = $dbmodelo_seguimiento->toArray();
        $this->assertModelData($modeloSeguimiento->toArray(), $dbmodelo_seguimiento);
    }

    /**
     * @test update
     */
    public function test_update_modelo_seguimiento()
    {
        $modeloSeguimiento = factory(modelo_seguimiento::class)->create();
        $fakemodelo_seguimiento = factory(modelo_seguimiento::class)->make()->toArray();

        $updatedmodelo_seguimiento = $this->modeloSeguimientoRepo->update($fakemodelo_seguimiento, $modeloSeguimiento->id);

        $this->assertModelData($fakemodelo_seguimiento, $updatedmodelo_seguimiento->toArray());
        $dbmodelo_seguimiento = $this->modeloSeguimientoRepo->find($modeloSeguimiento->id);
        $this->assertModelData($fakemodelo_seguimiento, $dbmodelo_seguimiento->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_modelo_seguimiento()
    {
        $modeloSeguimiento = factory(modelo_seguimiento::class)->create();

        $resp = $this->modeloSeguimientoRepo->delete($modeloSeguimiento->id);

        $this->assertTrue($resp);
        $this->assertNull(modelo_seguimiento::find($modeloSeguimiento->id), 'modelo_seguimiento should not exist in DB');
    }
}
