<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'product_id' => ['nullable', 'integer', 'exists:products,id'],
        'phone' => ['required', 'string', 'max:50'],
        'address' => ['required', 'string', 'max:255'],
        'preferred_date' => ['required', 'date'],
        'note' => ['nullable', 'string', 'max:2000'],
    ];
}

}
