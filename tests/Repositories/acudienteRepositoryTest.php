<?php namespace Tests\Repositories;

use App\Models\acudiente;
use App\Repositories\acudienteRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class acudienteRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var acudienteRepository
     */
    protected $acudienteRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->acudienteRepo = \App::make(acudienteRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_acudiente()
    {
        $acudiente = factory(acudiente::class)->make()->toArray();

        $createdacudiente = $this->acudienteRepo->create($acudiente);

        $createdacudiente = $createdacudiente->toArray();
        $this->assertArrayHasKey('id', $createdacudiente);
        $this->assertNotNull($createdacudiente['id'], 'Created acudiente must have id specified');
        $this->assertNotNull(acudiente::find($createdacudiente['id']), 'acudiente with given id must be in DB');
        $this->assertModelData($acudiente, $createdacudiente);
    }

    /**
     * @test read
     */
    public function test_read_acudiente()
    {
        $acudiente = factory(acudiente::class)->create();

        $dbacudiente = $this->acudienteRepo->find($acudiente->id);

        $dbacudiente = $dbacudiente->toArray();
        $this->assertModelData($acudiente->toArray(), $dbacudiente);
    }

    /**
     * @test update
     */
    public function test_update_acudiente()
    {
        $acudiente = factory(acudiente::class)->create();
        $fakeacudiente = factory(acudiente::class)->make()->toArray();

        $updatedacudiente = $this->acudienteRepo->update($fakeacudiente, $acudiente->id);

        $this->assertModelData($fakeacudiente, $updatedacudiente->toArray());
        $dbacudiente = $this->acudienteRepo->find($acudiente->id);
        $this->assertModelData($fakeacudiente, $dbacudiente->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_acudiente()
    {
        $acudiente = factory(acudiente::class)->create();

        $resp = $this->acudienteRepo->delete($acudiente->id);

        $this->assertTrue($resp);
        $this->assertNull(acudiente::find($acudiente->id), 'acudiente should not exist in DB');
    }
}
