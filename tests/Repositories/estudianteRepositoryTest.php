<?php namespace Tests\Repositories;

use App\Models\estudiante;
use App\Repositories\estudianteRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class estudianteRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var estudianteRepository
     */
    protected $estudianteRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->estudianteRepo = \App::make(estudianteRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_estudiante()
    {
        $estudiante = factory(estudiante::class)->make()->toArray();

        $createdestudiante = $this->estudianteRepo->create($estudiante);

        $createdestudiante = $createdestudiante->toArray();
        $this->assertArrayHasKey('id', $createdestudiante);
        $this->assertNotNull($createdestudiante['id'], 'Created estudiante must have id specified');
        $this->assertNotNull(estudiante::find($createdestudiante['id']), 'estudiante with given id must be in DB');
        $this->assertModelData($estudiante, $createdestudiante);
    }

    /**
     * @test read
     */
    public function test_read_estudiante()
    {
        $estudiante = factory(estudiante::class)->create();

        $dbestudiante = $this->estudianteRepo->find($estudiante->id);

        $dbestudiante = $dbestudiante->toArray();
        $this->assertModelData($estudiante->toArray(), $dbestudiante);
    }

    /**
     * @test update
     */
    public function test_update_estudiante()
    {
        $estudiante = factory(estudiante::class)->create();
        $fakeestudiante = factory(estudiante::class)->make()->toArray();

        $updatedestudiante = $this->estudianteRepo->update($fakeestudiante, $estudiante->id);

        $this->assertModelData($fakeestudiante, $updatedestudiante->toArray());
        $dbestudiante = $this->estudianteRepo->find($estudiante->id);
        $this->assertModelData($fakeestudiante, $dbestudiante->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_estudiante()
    {
        $estudiante = factory(estudiante::class)->create();

        $resp = $this->estudianteRepo->delete($estudiante->id);

        $this->assertTrue($resp);
        $this->assertNull(estudiante::find($estudiante->id), 'estudiante should not exist in DB');
    }
}
