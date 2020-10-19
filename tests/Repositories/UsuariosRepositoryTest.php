<?php namespace Tests\Repositories;

use App\Models\Usuarios;
use App\Repositories\UsuariosRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class UsuariosRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var UsuariosRepository
     */
    protected $usuariosRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->usuariosRepo = \App::make(UsuariosRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_usuarios()
    {
        $usuarios = factory(Usuarios::class)->make()->toArray();

        $createdUsuarios = $this->usuariosRepo->create($usuarios);

        $createdUsuarios = $createdUsuarios->toArray();
        $this->assertArrayHasKey('id', $createdUsuarios);
        $this->assertNotNull($createdUsuarios['id'], 'Created Usuarios must have id specified');
        $this->assertNotNull(Usuarios::find($createdUsuarios['id']), 'Usuarios with given id must be in DB');
        $this->assertModelData($usuarios, $createdUsuarios);
    }

    /**
     * @test read
     */
    public function test_read_usuarios()
    {
        $usuarios = factory(Usuarios::class)->create();

        $dbUsuarios = $this->usuariosRepo->find($usuarios->id);

        $dbUsuarios = $dbUsuarios->toArray();
        $this->assertModelData($usuarios->toArray(), $dbUsuarios);
    }

    /**
     * @test update
     */
    public function test_update_usuarios()
    {
        $usuarios = factory(Usuarios::class)->create();
        $fakeUsuarios = factory(Usuarios::class)->make()->toArray();

        $updatedUsuarios = $this->usuariosRepo->update($fakeUsuarios, $usuarios->id);

        $this->assertModelData($fakeUsuarios, $updatedUsuarios->toArray());
        $dbUsuarios = $this->usuariosRepo->find($usuarios->id);
        $this->assertModelData($fakeUsuarios, $dbUsuarios->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_usuarios()
    {
        $usuarios = factory(Usuarios::class)->create();

        $resp = $this->usuariosRepo->delete($usuarios->id);

        $this->assertTrue($resp);
        $this->assertNull(Usuarios::find($usuarios->id), 'Usuarios should not exist in DB');
    }
}
