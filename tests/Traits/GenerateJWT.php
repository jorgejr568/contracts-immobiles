<?php

namespace Tests\Traits;
use Database\Factories\UserFactory;

trait GenerateJWT{
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
}
