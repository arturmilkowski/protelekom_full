<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brand_id' => ['required'],
            'category_id' => ['required'],
            'slug' => ['required', 'max:255'],
            'name' => ['required', 'max:255', Rule::unique('products', 'name')->ignore($this->product)],
            'description' => [],
            'img' => [],
            'site_description' => [],
            'site_keyword' => [],
            'hide' => ['required'],
        ];
    }
}
