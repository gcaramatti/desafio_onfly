<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Notifications\SendMailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\User;
use App\Http\Requests\Expense\CreateExpensesRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Response(['data' => Expense::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateExpensesRequest $request)
    {
        $user = auth()->user();

        if($request) {
            $expense = Expense::create($request->all());
            Notification::send($user, new SendMailNotification($expense));
    
            return Response(['data' => 'Despesa criada com sucesso'], 200);
        }
        
        return Response(['data' => 'Erro ao criar despesa'], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = Expense::findOrFail($id);
    
        if($expense) {
            return Response(['data' => $expense], 200);
        }

        return Response(['data' => 'Despesa não encontrada'], 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateExpensesRequest $request, string $id)
    {
        $expense = Expense::findOrFail($id);
        $this->authorize('update', $expense);

        if($expense) {
            $expense->description = $request->description;
            $expense->expenses_date = $request->expenses_date;
            $expense->price = $request->price;
            $expense->user_id = $request->user_id;

            $expense->save();

            return Response(['data' => 'Despesa atualizada com sucesso'], 200);
        }
        
        return Response(['data' => 'Erro ao atualizar despesa'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail($id);

        if($expense) {
            $this->authorize('delete', $expense);
            Expense::destroy($id);
    
            return Response(['data' => 'Despesa apagada com sucesso'], 200);
        }
        return Response(['data' => 'Despesa não encontrada'], 500);
    }
}
