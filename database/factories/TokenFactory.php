<?php

namespace Database\Factories;

use App\Models\Token;
use Illuminate\Database\Eloquent\Factories\Factory;

class TokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Token::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'access_token' => $this->faker->text(1000),
            'refresh_token' => $this->faker->text(50),
            'grant_id' => $this->faker->text(36),
            'token_type' => $this->faker->text(10),
            'expires_at' => $this->faker->randomNumber(3),
        ];
    }
}
