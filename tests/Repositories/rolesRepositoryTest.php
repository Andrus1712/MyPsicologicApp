<?php namespace Tests\Repositories;

use App\Models\roles;
use App\Repositories\rolesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class rolesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var rolesRepository
     */
    protected $rolesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->rolesRepo = \App::make(rolesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_roles()
    {
        $roles = factory(roles::class)->make()->toArray();

        $createdroles = $this->rolesRepo->create($roles);

        $createdroles = $createdroles->toArray();
        $this->assertArrayHasKey('id', $createdroles);
        $this->assertNotNull($createdroles['id'], 'Created roles must have id specified');
        $this->assertNotNull(roles::find($createdroles['id']), 'roles with given id must be in DB');
        $this->assertModelData($roles, $createdroles);
    }

    /**
     * @test read
     */
    public function test_read_roles()
    {
        $roles = factory(roles::class)->create();

        $dbroles = $this->rolesRepo->find($roles->id);

        $dbroles = $dbroles->toArray();
        $this->assertModelData($roles->toArray(), $dbroles);
    }

    /**
     * @test update
     */
    public function test_update_roles()
    {
        $roles = factory(roles::class)->create();
        $fakeroles = factory(roles::class)->make()->toArray();

        $updatedroles = $this->rolesRepo->update($fakeroles, $roles->id);

        $this->assertModelData($fakeroles, $updatedroles->toArray());
        $dbroles = $this->rolesRepo->find($roles->id);
        $this->assertModelData($fakeroles, $dbroles->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_roles()
    {
        $roles = factory(roles::class)->create();

        $resp = $this->rolesRepo->delete($roles->id);

        $this->assertTrue($resp);
        $this->assertNull(roles::find($roles->id), 'roles should not exist in DB');
    }
}
