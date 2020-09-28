<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\acudiente;

class acudienteApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_acudiente()
    {
        $acudiente = factory(acudiente::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/acudientes', $acudiente
        );

        $this->assertApiResponse($acudiente);
    }

    /**
     * @test
     */
    public function test_read_acudiente()
    {
        $acudiente = factory(acudiente::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/acudientes/'.$acudiente->id
        );

        $this->assertApiResponse($acudiente->toArray());
    }

    /**
     * @test
     */
    public function test_update_acudiente()
    {
        $acudiente = factory(acudiente::class)->create();
        $editedacudiente = factory(acudiente::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/acudientes/'.$acudiente->id,
            $editedacudiente
        );

        $this->assertApiResponse($editedacudiente);
    }

    /**
     * @test
     */
    public function test_delete_acudiente()
    {
        $acudiente = factory(acudiente::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/acudientes/'.$acudiente->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/acudientes/'.$acudiente->id
        );

        $this->response->assertStatus(404);
    }
}
