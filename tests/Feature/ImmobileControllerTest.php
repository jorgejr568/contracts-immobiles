<?php

namespace Tests\Feature;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImmobileControllerTest extends TestCase
{
    use RefreshDatabase;

    private function generateAuthorization()
    {
        $user = UserFactory::new(['password' => bcrypt('password')])->create();
        $response = $this->post('/api/auth', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $jwt = $response->json('access_token');
        $token_type = $response->json('token_type');

        return "$token_type $jwt";
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexWithNoAuthentication()
    {
        $response = $this->get('/api/immobile');
        $response->assertStatus(401);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/api/immobile', [
            'Authorization' => $this->generateAuthorization(),
        ]);
        $response->assertStatus(200);
    }
}
