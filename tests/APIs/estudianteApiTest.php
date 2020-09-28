<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\estudiante;

class estudianteApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_estudiante()
    {
        $estudiante = factory(estudiante::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/estudiantes', $estudiante
        );

        $this->assertApiResponse($estudiante);
    }

    /**
     * @test
     */
    public function test_read_estudiante()
    {
        $estudiante = factory(estudiante::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/estudiantes/'.$estudiante->id
        );

        $this->assertApiResponse($estudiante->toArray());
    }

    /**
     * @test
     */
    public function test_update_estudiante()
    {
        $estudiante = factory(estudiante::class)->create();
        $editedestudiante = factory(estudiante::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/estudiantes/'.$estudiante->id,
            $editedestudiante
        );

        $this->assertApiResponse($editedestudiante);
    }

    /**
     * @test
     */
    public function test_delete_estudiante()
    {
        $estudiante = factory(estudiante::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/estudiantes/'.$estudiante->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/estudiantes/'.$estudiante->id
        );

        $this->response->assertStatus(404);
    }
}
