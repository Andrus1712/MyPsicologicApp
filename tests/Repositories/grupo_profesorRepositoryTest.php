<?php namespace Tests\Repositories;

use App\Models\grupo_profesor;
use App\Repositories\grupo_profesorRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class grupo_profesorRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var grupo_profesorRepository
     */
    protected $grupoProfesorRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->grupoProfesorRepo = \App::make(grupo_profesorRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_grupo_profesor()
    {
        $grupoProfesor = factory(grupo_profesor::class)->make()->toArray();

        $createdgrupo_profesor = $this->grupoProfesorRepo->create($grupoProfesor);

        $createdgrupo_profesor = $createdgrupo_profesor->toArray();
        $this->assertArrayHasKey('id', $createdgrupo_profesor);
        $this->assertNotNull($createdgrupo_profesor['id'], 'Created grupo_profesor must have id specified');
        $this->assertNotNull(grupo_profesor::find($createdgrupo_profesor['id']), 'grupo_profesor with given id must be in DB');
        $this->assertModelData($grupoProfesor, $createdgrupo_profesor);
    }

    /**
     * @test read
     */
    public function test_read_grupo_profesor()
    {
        $grupoProfesor = factory(grupo_profesor::class)->create();

        $dbgrupo_profesor = $this->grupoProfesorRepo->find($grupoProfesor->id);

        $dbgrupo_profesor = $dbgrupo_profesor->toArray();
        $this->assertModelData($grupoProfesor->toArray(), $dbgrupo_profesor);
    }

    /**
     * @test update
     */
    public function test_update_grupo_profesor()
    {
        $grupoProfesor = factory(grupo_profesor::class)->create();
        $fakegrupo_profesor = factory(grupo_profesor::class)->make()->toArray();

        $updatedgrupo_profesor = $this->grupoProfesorRepo->update($fakegrupo_profesor, $grupoProfesor->id);

        $this->assertModelData($fakegrupo_profesor, $updatedgrupo_profesor->toArray());
        $dbgrupo_profesor = $this->grupoProfesorRepo->find($grupoProfesor->id);
        $this->assertModelData($fakegrupo_profesor, $dbgrupo_profesor->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_grupo_profesor()
    {
        $grupoProfesor = factory(grupo_profesor::class)->create();

        $resp = $this->grupoProfesorRepo->delete($grupoProfesor->id);

        $this->assertTrue($resp);
        $this->assertNull(grupo_profesor::find($grupoProfesor->id), 'grupo_profesor should not exist in DB');
    }
}
