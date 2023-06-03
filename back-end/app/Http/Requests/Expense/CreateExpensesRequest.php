<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CreateExpensesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required|max:191',
            'expenses_date' => 'required|before_or_equal:now',
            'price' => 'required|numeric|min:0',
            'user_id' => 'required|exists:App\Models\User,id|in:' . auth()->user()->id
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));

    }

    public function messages()
    {
        return [
            'description.required' => 'Campo descricao obrigatorio',
            'expenses_date.required' => 'Campo data obrigatorio',
            'price.required' => 'Campo valor obrigatorio',
            'user_id.required' => 'Voce deve informar um usuario valido para a despesa',
            'user_id.exists' => 'O usuario informado nao existe',
            'user_id.in' => 'Voce so pode criar despesas para seu proprio usuario.',
            'expenses_date.before_or_equal' => 'A data nao pode ser futura.',
            'price.min' => 'O valor deve ser no minimo 0'
        ];
    }
}
