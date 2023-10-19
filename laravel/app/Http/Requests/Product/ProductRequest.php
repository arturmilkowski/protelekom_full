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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        /*
        if ($this->hide == 'true') {
            $this['hide'] = true;
        } else {
            $this['hide'] = false;
        }
        */
        $this['hide'] = filter_var($this->hide, FILTER_VALIDATE_BOOLEAN);
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
            'img' => ['sometimes', 'image'],
            'site_description' => ['max:255'],
            'site_keyword' => ['max:255'],
            'hide' => ['required', 'boolean'],
        ];
    }
}
