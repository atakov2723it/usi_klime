<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestUpdateRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
            'phone' => ['required', 'string'],
            'address' => ['required', 'string'],
            'preferred_date' => ['required', 'date'],
            'note' => ['nullable', 'string'],
            'status' => ['required', 'in:new,scheduled,done,cancelled'],
        ];
    }
}
