<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\modelo_seguimiento;

class modelo_seguimientoApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_modelo_seguimiento()
    {
        $modeloSeguimiento = factory(modelo_seguimiento::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/modelo_seguimientos', $modeloSeguimiento
        );

        $this->assertApiResponse($modeloSeguimiento);
    }

    /**
     * @test
     */
    public function test_read_modelo_seguimiento()
    {
        $modeloSeguimiento = factory(modelo_seguimiento::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/modelo_seguimientos/'.$modeloSeguimiento->id
        );

        $this->assertApiResponse($modeloSeguimiento->toArray());
    }

    /**
     * @test
     */
    public function test_update_modelo_seguimiento()
    {
        $modeloSeguimiento = factory(modelo_seguimiento::class)->create();
        $editedmodelo_seguimiento = factory(modelo_seguimiento::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/modelo_seguimientos/'.$modeloSeguimiento->id,
            $editedmodelo_seguimiento
        );

        $this->assertApiResponse($editedmodelo_seguimiento);
    }

    /**
     * @test
     */
    public function test_delete_modelo_seguimiento()
    {
        $modeloSeguimiento = factory(modelo_seguimiento::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/modelo_seguimientos/'.$modeloSeguimiento->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/modelo_seguimientos/'.$modeloSeguimiento->id
        );

        $this->response->assertStatus(404);
    }
}
