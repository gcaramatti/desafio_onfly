<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'created_at' => now(),
            'password' => '$2y$10$hHfs6XL3zyLj7oQugjy5VeAJ3eh1JnQA7EVJjJKmW7ce8c3VTIXBu', // password
            'is_admin' => true,
            'remember_token' => null,
        ];
    }
}
