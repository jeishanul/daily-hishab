<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = request()->isMethod('put');
        $isRequired = 'required';
        if ($method) {
            $isRequired = 'nullable';
        }
        return [
            'expense_category_id' => 'required|integer',
            'warehouse_id' => 'required|integer',
            'amount' => $isRequired . '|numeric',
            'account_id' => 'nullable|integer',
            'note' => 'nullable|string',
        ];
    }
}
