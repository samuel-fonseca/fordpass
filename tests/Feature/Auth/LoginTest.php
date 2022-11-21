<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function anUserCanLogin()
    {
        $user = User::factory()->create();

        $this->json('post', '/login', [
            'username' => $user->username,
            'password' => 'password',
        ])
        ->seeJson(['username' => $user->username])
        ->assertResponseOk();
    }
}
