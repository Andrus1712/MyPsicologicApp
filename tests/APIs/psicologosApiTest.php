<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\psicologos;

class psicologosApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_psicologos()
    {
        $psicologos = factory(psicologos::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/psicologos', $psicologos
        );

        $this->assertApiResponse($psicologos);
    }

    /**
     * @test
     */
    public function test_read_psicologos()
    {
        $psicologos = factory(psicologos::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/psicologos/'.$psicologos->id
        );

        $this->assertApiResponse($psicologos->toArray());
    }

    /**
     * @test
     */
    public function test_update_psicologos()
    {
        $psicologos = factory(psicologos::class)->create();
        $editedpsicologos = factory(psicologos::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/psicologos/'.$psicologos->id,
            $editedpsicologos
        );

        $this->assertApiResponse($editedpsicologos);
    }

    /**
     * @test
     */
    public function test_delete_psicologos()
    {
        $psicologos = factory(psicologos::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/psicologos/'.$psicologos->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/psicologos/'.$psicologos->id
        );

        $this->response->assertStatus(404);
    }
}
