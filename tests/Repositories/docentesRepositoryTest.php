<?php namespace Tests\Repositories;

use App\Models\docentes;
use App\Repositories\docentesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class docentesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var docentesRepository
     */
    protected $docentesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->docentesRepo = \App::make(docentesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_docentes()
    {
        $docentes = factory(docentes::class)->make()->toArray();

        $createddocentes = $this->docentesRepo->create($docentes);

        $createddocentes = $createddocentes->toArray();
        $this->assertArrayHasKey('id', $createddocentes);
        $this->assertNotNull($createddocentes['id'], 'Created docentes must have id specified');
        $this->assertNotNull(docentes::find($createddocentes['id']), 'docentes with given id must be in DB');
        $this->assertModelData($docentes, $createddocentes);
    }

    /**
     * @test read
     */
    public function test_read_docentes()
    {
        $docentes = factory(docentes::class)->create();

        $dbdocentes = $this->docentesRepo->find($docentes->id);

        $dbdocentes = $dbdocentes->toArray();
        $this->assertModelData($docentes->toArray(), $dbdocentes);
    }

    /**
     * @test update
     */
    public function test_update_docentes()
    {
        $docentes = factory(docentes::class)->create();
        $fakedocentes = factory(docentes::class)->make()->toArray();

        $updateddocentes = $this->docentesRepo->update($fakedocentes, $docentes->id);

        $this->assertModelData($fakedocentes, $updateddocentes->toArray());
        $dbdocentes = $this->docentesRepo->find($docentes->id);
        $this->assertModelData($fakedocentes, $dbdocentes->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_docentes()
    {
        $docentes = factory(docentes::class)->create();

        $resp = $this->docentesRepo->delete($docentes->id);

        $this->assertTrue($resp);
        $this->assertNull(docentes::find($docentes->id), 'docentes should not exist in DB');
    }
}
