<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\avances;

class avancesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_avances()
    {
        $avances = factory(avances::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/avances', $avances
        );

        $this->assertApiResponse($avances);
    }

    /**
     * @test
     */
    public function test_read_avances()
    {
        $avances = factory(avances::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/avances/'.$avances->id
        );

        $this->assertApiResponse($avances->toArray());
    }

    /**
     * @test
     */
    public function test_update_avances()
    {
        $avances = factory(avances::class)->create();
        $editedavances = factory(avances::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/avances/'.$avances->id,
            $editedavances
        );

        $this->assertApiResponse($editedavances);
    }

    /**
     * @test
     */
    public function test_delete_avances()
    {
        $avances = factory(avances::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/avances/'.$avances->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/avances/'.$avances->id
        );

        $this->response->assertStatus(404);
    }
}
