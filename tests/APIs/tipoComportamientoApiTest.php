<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\tipoComportamiento;

class tipoComportamientoApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tipo_comportamiento()
    {
        $tipoComportamiento = factory(tipoComportamiento::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/tipo_comportamientos', $tipoComportamiento
        );

        $this->assertApiResponse($tipoComportamiento);
    }

    /**
     * @test
     */
    public function test_read_tipo_comportamiento()
    {
        $tipoComportamiento = factory(tipoComportamiento::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/tipo_comportamientos/'.$tipoComportamiento->id
        );

        $this->assertApiResponse($tipoComportamiento->toArray());
    }

    /**
     * @test
     */
    public function test_update_tipo_comportamiento()
    {
        $tipoComportamiento = factory(tipoComportamiento::class)->create();
        $editedtipoComportamiento = factory(tipoComportamiento::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/tipo_comportamientos/'.$tipoComportamiento->id,
            $editedtipoComportamiento
        );

        $this->assertApiResponse($editedtipoComportamiento);
    }

    /**
     * @test
     */
    public function test_delete_tipo_comportamiento()
    {
        $tipoComportamiento = factory(tipoComportamiento::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/tipo_comportamientos/'.$tipoComportamiento->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/tipo_comportamientos/'.$tipoComportamiento->id
        );

        $this->response->assertStatus(404);
    }
}
