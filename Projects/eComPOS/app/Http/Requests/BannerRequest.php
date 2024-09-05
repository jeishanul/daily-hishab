<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
        $isImage = 'required';
        if ($this->method() == 'PUT') {
            $isImage = 'nullable';
        }
        return [
            'title' => 'required|string|max:255',
            'image' => $isImage . '|mimes:jpg,jpeg,png,gif',
            'url' => 'required|string|max:255'
        ];
    }
}
