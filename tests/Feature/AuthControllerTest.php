<?php

namespace Tests\Feature;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Must return jwt structure if valid data provided
     *
     * @return void
     */
    public function testLoginWithValidData()
    {
        $user = UserFactory::new(["password" => bcrypt("password")])->create();

        $response = $this->post('/api/auth', [
            "email" => $user->email,
            "password" => "password"
        ]);

        $response->assertJsonStructure([
            "access_token",
            "token_type",
            "expires_in"
        ]);
    }

    /**
     * Must return 401 if password is invalid
     *
     * @return void
     */
    public function testLoginWithInvalidPassword()
    {
        $user = UserFactory::new(["password" => bcrypt("password")])->create();

        $response = $this->post('/api/auth', [
            "email" => $user->email,
            "password" => "invalid_password"
        ]);

        $response->assertStatus(401);
    }

    /**
     * Must return user data if valid jwt provided
     *
     * @return void
     */
    public function testMeWithValidJwt()
    {
        $user = UserFactory::new(["password" => bcrypt("password")])->create();

        $jwt_response = $this->post('/api/auth', [
            "email" => $user->email,
            "password" => "password"
        ]);

        $jwt = $jwt_response->json("access_token");
        $token_type = $jwt_response->json("token_type");

        $response = $this->get('/api/auth', [
            "Authorization" => "$token_type $jwt"
        ]);

        $response->assertJson($user->toArray());
    }

    /**
     * Must return 401 if jwt is invalid
     *
     * @return void
     */
    public function testMeWithInvalidJwt()
    {
        $response = $this->get('/api/auth', [
            "Authorization" => "Bearer invalid_token"
        ]);

        $response->assertStatus(401);
    }



}