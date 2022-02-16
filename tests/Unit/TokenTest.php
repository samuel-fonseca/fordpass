<?php

namespace Tests\Unit;

use App\Models\Token;
use Tests\TestCase;

class TokenTest extends TestCase
{
    /** @test */
    public function it_sets_expires_at_attribute()
    {
        $token = Token::factory()->make([
            'expires_at' => 300
        ]);

        $this->assertNotEquals(300, $token->expires_at);
    }
}
