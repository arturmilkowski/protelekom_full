<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
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
        return [
            'product_id' => ['required'], // 'integer'
            'condition_id' => ['required', 'min:1'], // 'numeric', 'max:99'
            'slug' => ['required', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:1', 'max:9999.99'],
            'promo_price' => ['sometimes', 'numeric', 'min:0.00', 'max:9999.99'],
            'quantity' => ['required', 'numeric', 'min:0', 'max:255'],
            'hide' => ['boolean'], // 'sometimes',
            'description' => [],
            'img' => ['sometimes', 'image'], // 'file',
        ];
    }
}
