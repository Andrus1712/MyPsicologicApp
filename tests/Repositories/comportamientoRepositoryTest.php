<?php namespace Tests\Repositories;

use App\Models\comportamiento;
use App\Repositories\comportamientoRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class comportamientoRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var comportamientoRepository
     */
    protected $comportamientoRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->comportamientoRepo = \App::make(comportamientoRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_comportamiento()
    {
        $comportamiento = factory(comportamiento::class)->make()->toArray();

        $createdcomportamiento = $this->comportamientoRepo->create($comportamiento);

        $createdcomportamiento = $createdcomportamiento->toArray();
        $this->assertArrayHasKey('id', $createdcomportamiento);
        $this->assertNotNull($createdcomportamiento['id'], 'Created comportamiento must have id specified');
        $this->assertNotNull(comportamiento::find($createdcomportamiento['id']), 'comportamiento with given id must be in DB');
        $this->assertModelData($comportamiento, $createdcomportamiento);
    }

    /**
     * @test read
     */
    public function test_read_comportamiento()
    {
        $comportamiento = factory(comportamiento::class)->create();

        $dbcomportamiento = $this->comportamientoRepo->find($comportamiento->id);

        $dbcomportamiento = $dbcomportamiento->toArray();
        $this->assertModelData($comportamiento->toArray(), $dbcomportamiento);
    }

    /**
     * @test update
     */
    public function test_update_comportamiento()
    {
        $comportamiento = factory(comportamiento::class)->create();
        $fakecomportamiento = factory(comportamiento::class)->make()->toArray();

        $updatedcomportamiento = $this->comportamientoRepo->update($fakecomportamiento, $comportamiento->id);

        $this->assertModelData($fakecomportamiento, $updatedcomportamiento->toArray());
        $dbcomportamiento = $this->comportamientoRepo->find($comportamiento->id);
        $this->assertModelData($fakecomportamiento, $dbcomportamiento->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_comportamiento()
    {
        $comportamiento = factory(comportamiento::class)->create();

        $resp = $this->comportamientoRepo->delete($comportamiento->id);

        $this->assertTrue($resp);
        $this->assertNull(comportamiento::find($comportamiento->id), 'comportamiento should not exist in DB');
    }
}
