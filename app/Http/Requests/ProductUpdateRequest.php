<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'btu' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'stock' => ['required', 'integer'],
            'description' => ['nullable', 'string'],
        ];
    }
}
