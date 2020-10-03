<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\grupo_profesor;

class grupo_profesorApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_grupo_profesor()
    {
        $grupoProfesor = factory(grupo_profesor::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/grupo_profesors', $grupoProfesor
        );

        $this->assertApiResponse($grupoProfesor);
    }

    /**
     * @test
     */
    public function test_read_grupo_profesor()
    {
        $grupoProfesor = factory(grupo_profesor::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/grupo_profesors/'.$grupoProfesor->id
        );

        $this->assertApiResponse($grupoProfesor->toArray());
    }

    /**
     * @test
     */
    public function test_update_grupo_profesor()
    {
        $grupoProfesor = factory(grupo_profesor::class)->create();
        $editedgrupo_profesor = factory(grupo_profesor::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/grupo_profesors/'.$grupoProfesor->id,
            $editedgrupo_profesor
        );

        $this->assertApiResponse($editedgrupo_profesor);
    }

    /**
     * @test
     */
    public function test_delete_grupo_profesor()
    {
        $grupoProfesor = factory(grupo_profesor::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/grupo_profesors/'.$grupoProfesor->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/grupo_profesors/'.$grupoProfesor->id
        );

        $this->response->assertStatus(404);
    }
}
