<?php namespace Tests\Repositories;

use App\Models\docente;
use App\Repositories\docenteRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class docenteRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var docenteRepository
     */
    protected $docenteRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->docenteRepo = \App::make(docenteRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_docente()
    {
        $docente = factory(docente::class)->make()->toArray();

        $createddocente = $this->docenteRepo->create($docente);

        $createddocente = $createddocente->toArray();
        $this->assertArrayHasKey('id', $createddocente);
        $this->assertNotNull($createddocente['id'], 'Created docente must have id specified');
        $this->assertNotNull(docente::find($createddocente['id']), 'docente with given id must be in DB');
        $this->assertModelData($docente, $createddocente);
    }

    /**
     * @test read
     */
    public function test_read_docente()
    {
        $docente = factory(docente::class)->create();

        $dbdocente = $this->docenteRepo->find($docente->id);

        $dbdocente = $dbdocente->toArray();
        $this->assertModelData($docente->toArray(), $dbdocente);
    }

    /**
     * @test update
     */
    public function test_update_docente()
    {
        $docente = factory(docente::class)->create();
        $fakedocente = factory(docente::class)->make()->toArray();

        $updateddocente = $this->docenteRepo->update($fakedocente, $docente->id);

        $this->assertModelData($fakedocente, $updateddocente->toArray());
        $dbdocente = $this->docenteRepo->find($docente->id);
        $this->assertModelData($fakedocente, $dbdocente->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_docente()
    {
        $docente = factory(docente::class)->create();

        $resp = $this->docenteRepo->delete($docente->id);

        $this->assertTrue($resp);
        $this->assertNull(docente::find($docente->id), 'docente should not exist in DB');
    }
}
