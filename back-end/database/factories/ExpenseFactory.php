<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition()
    {
        return [
            'description' => fake()->sentence,
            'expenses_date' => fake()->date,
            'price' => fake()->randomFloat(2, 1, 1000),
            'user_id' => User::factory()->create()->id,
        ];
    }
}