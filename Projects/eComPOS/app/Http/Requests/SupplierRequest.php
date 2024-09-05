<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif',
            'company_name' => 'required|string|max:255|unique:personal_infos,company_name,' . $this->user?->personalInfo?->id,
            'email' => 'required|email|unique:users,email,' . $this->user?->id,
            'phone' => 'required|string|max:16|unique:personal_infos,phone,' . $this->user?->personalInfo?->id,
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'tax_no' => 'nullable|string|max:255|unique:personal_infos,tax_no,' . $this->user?->personalInfo?->id,
            'state' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ];
    }
}
