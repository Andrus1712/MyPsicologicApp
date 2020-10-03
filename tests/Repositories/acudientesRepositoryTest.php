<?php namespace Tests\Repositories;

use App\Models\acudientes;
use App\Repositories\acudientesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class acudientesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var acudientesRepository
     */
    protected $acudientesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->acudientesRepo = \App::make(acudientesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_acudientes()
    {
        $acudientes = factory(acudientes::class)->make()->toArray();

        $createdacudientes = $this->acudientesRepo->create($acudientes);

        $createdacudientes = $createdacudientes->toArray();
        $this->assertArrayHasKey('id', $createdacudientes);
        $this->assertNotNull($createdacudientes['id'], 'Created acudientes must have id specified');
        $this->assertNotNull(acudientes::find($createdacudientes['id']), 'acudientes with given id must be in DB');
        $this->assertModelData($acudientes, $createdacudientes);
    }

    /**
     * @test read
     */
    public function test_read_acudientes()
    {
        $acudientes = factory(acudientes::class)->create();

        $dbacudientes = $this->acudientesRepo->find($acudientes->id);

        $dbacudientes = $dbacudientes->toArray();
        $this->assertModelData($acudientes->toArray(), $dbacudientes);
    }

    /**
     * @test update
     */
    public function test_update_acudientes()
    {
        $acudientes = factory(acudientes::class)->create();
        $fakeacudientes = factory(acudientes::class)->make()->toArray();

        $updatedacudientes = $this->acudientesRepo->update($fakeacudientes, $acudientes->id);

        $this->assertModelData($fakeacudientes, $updatedacudientes->toArray());
        $dbacudientes = $this->acudientesRepo->find($acudientes->id);
        $this->assertModelData($fakeacudientes, $dbacudientes->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_acudientes()
    {
        $acudientes = factory(acudientes::class)->create();

        $resp = $this->acudientesRepo->delete($acudientes->id);

        $this->assertTrue($resp);
        $this->assertNull(acudientes::find($acudientes->id), 'acudientes should not exist in DB');
    }
}
