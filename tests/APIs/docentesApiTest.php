<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\docentes;

class docentesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_docentes()
    {
        $docentes = factory(docentes::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/docentes', $docentes
        );

        $this->assertApiResponse($docentes);
    }

    /**
     * @test
     */
    public function test_read_docentes()
    {
        $docentes = factory(docentes::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/docentes/'.$docentes->id
        );

        $this->assertApiResponse($docentes->toArray());
    }

    /**
     * @test
     */
    public function test_update_docentes()
    {
        $docentes = factory(docentes::class)->create();
        $editeddocentes = factory(docentes::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/docentes/'.$docentes->id,
            $editeddocentes
        );

        $this->assertApiResponse($editeddocentes);
    }

    /**
     * @test
     */
    public function test_delete_docentes()
    {
        $docentes = factory(docentes::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/docentes/'.$docentes->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/docentes/'.$docentes->id
        );

        $this->response->assertStatus(404);
    }
}
