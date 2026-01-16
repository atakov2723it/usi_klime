<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'desired_date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:2000'],
            'status' => ['nullable', 'string', 'max:50'], // ako ima status u tabeli
        ];
    }
}
