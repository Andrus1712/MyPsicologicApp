<?php namespace Tests\Repositories;

use App\Models\grupo;
use App\Repositories\grupoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class grupoRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var grupoRepository
     */
    protected $grupoRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->grupoRepo = \App::make(grupoRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_grupo()
    {
        $grupo = factory(grupo::class)->make()->toArray();

        $createdgrupo = $this->grupoRepo->create($grupo);

        $createdgrupo = $createdgrupo->toArray();
        $this->assertArrayHasKey('id', $createdgrupo);
        $this->assertNotNull($createdgrupo['id'], 'Created grupo must have id specified');
        $this->assertNotNull(grupo::find($createdgrupo['id']), 'grupo with given id must be in DB');
        $this->assertModelData($grupo, $createdgrupo);
    }

    /**
     * @test read
     */
    public function test_read_grupo()
    {
        $grupo = factory(grupo::class)->create();

        $dbgrupo = $this->grupoRepo->find($grupo->id);

        $dbgrupo = $dbgrupo->toArray();
        $this->assertModelData($grupo->toArray(), $dbgrupo);
    }

    /**
     * @test update
     */
    public function test_update_grupo()
    {
        $grupo = factory(grupo::class)->create();
        $fakegrupo = factory(grupo::class)->make()->toArray();

        $updatedgrupo = $this->grupoRepo->update($fakegrupo, $grupo->id);

        $this->assertModelData($fakegrupo, $updatedgrupo->toArray());
        $dbgrupo = $this->grupoRepo->find($grupo->id);
        $this->assertModelData($fakegrupo, $dbgrupo->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_grupo()
    {
        $grupo = factory(grupo::class)->create();

        $resp = $this->grupoRepo->delete($grupo->id);

        $this->assertTrue($resp);
        $this->assertNull(grupo::find($grupo->id), 'grupo should not exist in DB');
    }
}
