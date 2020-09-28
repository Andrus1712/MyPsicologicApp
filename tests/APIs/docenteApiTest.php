<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\docente;

class docenteApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_docente()
    {
        $docente = factory(docente::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/docentes', $docente
        );

        $this->assertApiResponse($docente);
    }

    /**
     * @test
     */
    public function test_read_docente()
    {
        $docente = factory(docente::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/docentes/'.$docente->id
        );

        $this->assertApiResponse($docente->toArray());
    }

    /**
     * @test
     */
    public function test_update_docente()
    {
        $docente = factory(docente::class)->create();
        $editeddocente = factory(docente::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/docentes/'.$docente->id,
            $editeddocente
        );

        $this->assertApiResponse($editeddocente);
    }

    /**
     * @test
     */
    public function test_delete_docente()
    {
        $docente = factory(docente::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/docentes/'.$docente->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/docentes/'.$docente->id
        );

        $this->response->assertStatus(404);
    }
}
