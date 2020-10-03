<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\comportamiento;

class comportamientoApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_comportamiento()
    {
        $comportamiento = factory(comportamiento::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/comportamientos', $comportamiento
        );

        $this->assertApiResponse($comportamiento);
    }

    /**
     * @test
     */
    public function test_read_comportamiento()
    {
        $comportamiento = factory(comportamiento::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/comportamientos/'.$comportamiento->id
        );

        $this->assertApiResponse($comportamiento->toArray());
    }

    /**
     * @test
     */
    public function test_update_comportamiento()
    {
        $comportamiento = factory(comportamiento::class)->create();
        $editedcomportamiento = factory(comportamiento::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/comportamientos/'.$comportamiento->id,
            $editedcomportamiento
        );

        $this->assertApiResponse($editedcomportamiento);
    }

    /**
     * @test
     */
    public function test_delete_comportamiento()
    {
        $comportamiento = factory(comportamiento::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/comportamientos/'.$comportamiento->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/comportamientos/'.$comportamiento->id
        );

        $this->response->assertStatus(404);
    }
}
