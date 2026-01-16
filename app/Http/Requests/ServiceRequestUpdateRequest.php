<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // admin ti je već zaštićen middleware-om
    }

    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'preferred_date' => ['required', 'date'],
            'note' => ['nullable', 'string'],
            'status' => ['required', 'in:new,scheduled,done,cancelled'],
        ];
    }
}
