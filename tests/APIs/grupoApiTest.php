<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\grupo;

class grupoApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_grupo()
    {
        $grupo = factory(grupo::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/grupos', $grupo
        );

        $this->assertApiResponse($grupo);
    }

    /**
     * @test
     */
    public function test_read_grupo()
    {
        $grupo = factory(grupo::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/grupos/'.$grupo->id
        );

        $this->assertApiResponse($grupo->toArray());
    }

    /**
     * @test
     */
    public function test_update_grupo()
    {
        $grupo = factory(grupo::class)->create();
        $editedgrupo = factory(grupo::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/grupos/'.$grupo->id,
            $editedgrupo
        );

        $this->assertApiResponse($editedgrupo);
    }

    /**
     * @test
     */
    public function test_delete_grupo()
    {
        $grupo = factory(grupo::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/grupos/'.$grupo->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/grupos/'.$grupo->id
        );

        $this->response->assertStatus(404);
    }
}
