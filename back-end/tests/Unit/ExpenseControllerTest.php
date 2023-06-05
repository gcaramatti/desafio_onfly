<?php

namespace Tests\Unit\Api;

use App\Models\Expense;
use App\Models\User;
use Tests\TestCase;

class ExpenseControllerTest extends TestCase
{
    /**
     * Test index method for logged-in user.
     */
    public function testIndexLoggedUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Expense::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->get('/api/expenses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'description',
                        'expenses_date',
                        'price',
                        'user_id',
                    ],
                ],
            ]);
    }

    /**
     * Test store method for logged-in user.
     */
    public function testStoreLoggedUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $expenseData = [
            'description' => 'Sample Expense',
            'expenses_date' => '2023-06-01',
            'price' => 100.50,
            'user_id' => $user->id,
        ];

        $response = $this->post('/api/expenses', $expenseData);

        $response->assertStatus(200)
            ->assertJson([
                'data' => 'Despesa criada com sucesso',
            ]);

        $this->assertDatabaseHas('expenses', $expenseData);
    }

    /**
     * Test store method for guest user (not logged in).
     */
    public function testStoreGuestUser()
    {
        $expenseData = [
            'description' => 'Sample Expense',
            'expenses_date' => '2023-06-01',
            'price' => 100.50,
            'user_id' => 9999, // Usuário não existente
        ];

        $response = $this->post('/api/expenses', $expenseData);

        $this->assertDatabaseMissing('expenses', $expenseData);
    }

    /**
     * Test show method for logged-in user.
     */
    public function testShowLoggedUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $expense = Expense::factory()->create(['user_id' => $user->id]);

        $response = $this->get('/api/expenses/' . $expense->id);

        $response->assertStatus(200);
    }

    /**
     * Test update method for logged-in user.
     */
    // public function testUpdateLoggedUser()
    // {
    //     $user = User::factory()->create();
    //     $this->actingAs($user);

    //     $expense = Expense::factory()->create(['user_id' => $user->id]);

    //     $updatedData = [
    //         'description' => 'Updated Expense',
    //         'expenses_date' => '2023-06-02',
    //         'price' => 200.75,
    //         'user_id' => $user->id,
    //     ];

    //     $response = $this->put('/api/expenses/' . $expense->id, $updatedData);

    //     $response->assertStatus(200);
    //     $this->assertDatabaseHas('expenses', $updatedData);
    // }

    /**
     * Test update method for guest user (not logged in).
     */
    public function testUpdateGuestUser()
    {
        $expense = Expense::factory()->create();

        $updatedData = [
            'description' => 'Updated Expense',
            'expenses_date' => '2023-06-02',
            'price' => 200.75,
            'user_id' => $expense->user_id,
        ];

        $response = $this->put('/api/expenses/' . $expense->id, $updatedData);

        $this->assertDatabaseMissing('expenses', $updatedData);
    }

    /**
     * Test destroy method for logged-in user.
     */
    public function testDestroyLoggedUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $expense = Expense::factory()->create(['user_id' => $user->id]);

        $response = $this->delete('/api/expenses/' . $expense->id);

        $response->assertStatus(200)
            ->assertJson([
                'data' => 'Despesa apagada com sucesso',
            ]);

        $this->assertDatabaseMissing('expenses', ['id' => $expense->id]);
    }

    /**
     * Test destroy method for guest user (not logged in).
     */
    public function testDestroyGuestUser()
    {
        $expense = Expense::factory()->create();

        $response = $this->delete('/api/expenses/' . $expense->id);

        $this->assertDatabaseHas('expenses', ['id' => $expense->id]);
    }
}
