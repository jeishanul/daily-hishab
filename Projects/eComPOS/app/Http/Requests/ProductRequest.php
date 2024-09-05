<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $unit_id = 'required|integer';
        $sale_unit_id = 'required|integer';
        $purchase_unit_id = 'required|integer';
        $price = 'required|numeric|max:9999999';
        $cost = 'required|numeric|max:9999999';

        $barcode_digits = getSettings('barcode_digits') ?? 8;
        $isImage = 'nullable';
        if ($this->more_image) {
            $isImage = 'required';
        }
        return [
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'image' => $isImage . '|mimes:png,jpg,jpeg',
            'code' => 'required|numeric|digits_between:' . $barcode_digits . ',' . $barcode_digits . '|unique:products,code,' . $this->product?->id,
            'price' => $price,
            'cost' => $cost,
            'barcode_symbology' => 'required|string|max:255',
            'brand_id' => 'required|integer',
            'category_id' => 'required|integer',
            'unit_id' => $unit_id,
            'sale_unit_id' => $sale_unit_id,
            'purchase_unit_id' => $purchase_unit_id,
            'alert_quantity' => 'nullable|integer',
            'is_featured' => 'nullable',
            'product_details' => 'nullable|string',
            'more_image' => 'nullable|array',
        ];
    }
}
