<?php namespace Tests\Repositories;

use App\Models\tipoComportamiento;
use App\Repositories\tipoComportamientoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class tipoComportamientoRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var tipoComportamientoRepository
     */
    protected $tipoComportamientoRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->tipoComportamientoRepo = \App::make(tipoComportamientoRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_tipo_comportamiento()
    {
        $tipoComportamiento = factory(tipoComportamiento::class)->make()->toArray();

        $createdtipoComportamiento = $this->tipoComportamientoRepo->create($tipoComportamiento);

        $createdtipoComportamiento = $createdtipoComportamiento->toArray();
        $this->assertArrayHasKey('id', $createdtipoComportamiento);
        $this->assertNotNull($createdtipoComportamiento['id'], 'Created tipoComportamiento must have id specified');
        $this->assertNotNull(tipoComportamiento::find($createdtipoComportamiento['id']), 'tipoComportamiento with given id must be in DB');
        $this->assertModelData($tipoComportamiento, $createdtipoComportamiento);
    }

    /**
     * @test read
     */
    public function test_read_tipo_comportamiento()
    {
        $tipoComportamiento = factory(tipoComportamiento::class)->create();

        $dbtipoComportamiento = $this->tipoComportamientoRepo->find($tipoComportamiento->id);

        $dbtipoComportamiento = $dbtipoComportamiento->toArray();
        $this->assertModelData($tipoComportamiento->toArray(), $dbtipoComportamiento);
    }

    /**
     * @test update
     */
    public function test_update_tipo_comportamiento()
    {
        $tipoComportamiento = factory(tipoComportamiento::class)->create();
        $faketipoComportamiento = factory(tipoComportamiento::class)->make()->toArray();

        $updatedtipoComportamiento = $this->tipoComportamientoRepo->update($faketipoComportamiento, $tipoComportamiento->id);

        $this->assertModelData($faketipoComportamiento, $updatedtipoComportamiento->toArray());
        $dbtipoComportamiento = $this->tipoComportamientoRepo->find($tipoComportamiento->id);
        $this->assertModelData($faketipoComportamiento, $dbtipoComportamiento->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_tipo_comportamiento()
    {
        $tipoComportamiento = factory(tipoComportamiento::class)->create();

        $resp = $this->tipoComportamientoRepo->delete($tipoComportamiento->id);

        $this->assertTrue($resp);
        $this->assertNull(tipoComportamiento::find($tipoComportamiento->id), 'tipoComportamiento should not exist in DB');
    }
}
