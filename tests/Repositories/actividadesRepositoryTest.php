<?php namespace Tests\Repositories;

use App\Models\actividades;
use App\Repositories\actividadesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class actividadesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var actividadesRepository
     */
    protected $actividadesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->actividadesRepo = \App::make(actividadesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_actividades()
    {
        $actividades = factory(actividades::class)->make()->toArray();

        $createdactividades = $this->actividadesRepo->create($actividades);

        $createdactividades = $createdactividades->toArray();
        $this->assertArrayHasKey('id', $createdactividades);
        $this->assertNotNull($createdactividades['id'], 'Created actividades must have id specified');
        $this->assertNotNull(actividades::find($createdactividades['id']), 'actividades with given id must be in DB');
        $this->assertModelData($actividades, $createdactividades);
    }

    /**
     * @test read
     */
    public function test_read_actividades()
    {
        $actividades = factory(actividades::class)->create();

        $dbactividades = $this->actividadesRepo->find($actividades->id);

        $dbactividades = $dbactividades->toArray();
        $this->assertModelData($actividades->toArray(), $dbactividades);
    }

    /**
     * @test update
     */
    public function test_update_actividades()
    {
        $actividades = factory(actividades::class)->create();
        $fakeactividades = factory(actividades::class)->make()->toArray();

        $updatedactividades = $this->actividadesRepo->update($fakeactividades, $actividades->id);

        $this->assertModelData($fakeactividades, $updatedactividades->toArray());
        $dbactividades = $this->actividadesRepo->find($actividades->id);
        $this->assertModelData($fakeactividades, $dbactividades->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_actividades()
    {
        $actividades = factory(actividades::class)->create();

        $resp = $this->actividadesRepo->delete($actividades->id);

        $this->assertTrue($resp);
        $this->assertNull(actividades::find($actividades->id), 'actividades should not exist in DB');
    }
}
