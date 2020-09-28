<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\psicologo;

class psicologoApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_psicologo()
    {
        $psicologo = factory(psicologo::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/psicologos', $psicologo
        );

        $this->assertApiResponse($psicologo);
    }

    /**
     * @test
     */
    public function test_read_psicologo()
    {
        $psicologo = factory(psicologo::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/psicologos/'.$psicologo->id
        );

        $this->assertApiResponse($psicologo->toArray());
    }

    /**
     * @test
     */
    public function test_update_psicologo()
    {
        $psicologo = factory(psicologo::class)->create();
        $editedpsicologo = factory(psicologo::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/psicologos/'.$psicologo->id,
            $editedpsicologo
        );

        $this->assertApiResponse($editedpsicologo);
    }

    /**
     * @test
     */
    public function test_delete_psicologo()
    {
        $psicologo = factory(psicologo::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/psicologos/'.$psicologo->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/psicologos/'.$psicologo->id
        );

        $this->response->assertStatus(404);
    }
}
