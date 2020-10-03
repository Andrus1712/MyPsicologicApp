<?php namespace Tests\Repositories;

use App\Models\estudiantes;
use App\Repositories\estudiantesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class estudiantesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var estudiantesRepository
     */
    protected $estudiantesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->estudiantesRepo = \App::make(estudiantesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_estudiantes()
    {
        $estudiantes = factory(estudiantes::class)->make()->toArray();

        $createdestudiantes = $this->estudiantesRepo->create($estudiantes);

        $createdestudiantes = $createdestudiantes->toArray();
        $this->assertArrayHasKey('id', $createdestudiantes);
        $this->assertNotNull($createdestudiantes['id'], 'Created estudiantes must have id specified');
        $this->assertNotNull(estudiantes::find($createdestudiantes['id']), 'estudiantes with given id must be in DB');
        $this->assertModelData($estudiantes, $createdestudiantes);
    }

    /**
     * @test read
     */
    public function test_read_estudiantes()
    {
        $estudiantes = factory(estudiantes::class)->create();

        $dbestudiantes = $this->estudiantesRepo->find($estudiantes->id);

        $dbestudiantes = $dbestudiantes->toArray();
        $this->assertModelData($estudiantes->toArray(), $dbestudiantes);
    }

    /**
     * @test update
     */
    public function test_update_estudiantes()
    {
        $estudiantes = factory(estudiantes::class)->create();
        $fakeestudiantes = factory(estudiantes::class)->make()->toArray();

        $updatedestudiantes = $this->estudiantesRepo->update($fakeestudiantes, $estudiantes->id);

        $this->assertModelData($fakeestudiantes, $updatedestudiantes->toArray());
        $dbestudiantes = $this->estudiantesRepo->find($estudiantes->id);
        $this->assertModelData($fakeestudiantes, $dbestudiantes->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_estudiantes()
    {
        $estudiantes = factory(estudiantes::class)->create();

        $resp = $this->estudiantesRepo->delete($estudiantes->id);

        $this->assertTrue($resp);
        $this->assertNull(estudiantes::find($estudiantes->id), 'estudiantes should not exist in DB');
    }
}
