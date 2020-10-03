<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\actividades;

class actividadesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_actividades()
    {
        $actividades = factory(actividades::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/actividades', $actividades
        );

        $this->assertApiResponse($actividades);
    }

    /**
     * @test
     */
    public function test_read_actividades()
    {
        $actividades = factory(actividades::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/actividades/'.$actividades->id
        );

        $this->assertApiResponse($actividades->toArray());
    }

    /**
     * @test
     */
    public function test_update_actividades()
    {
        $actividades = factory(actividades::class)->create();
        $editedactividades = factory(actividades::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/actividades/'.$actividades->id,
            $editedactividades
        );

        $this->assertApiResponse($editedactividades);
    }

    /**
     * @test
     */
    public function test_delete_actividades()
    {
        $actividades = factory(actividades::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/actividades/'.$actividades->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/actividades/'.$actividades->id
        );

        $this->response->assertStatus(404);
    }
}
