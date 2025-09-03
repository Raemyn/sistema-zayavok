<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // публично
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'email' => 'nullable|email|required_without:phone',
            'phone' => 'nullable|string|required_without:email|max:50',
            'source_id' => 'nullable|exists:sources,id',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required_without' => 'Нужно указать email или телефон',
            'phone.required_without' => 'Нужно указать email или телефон',
        ];
    }
}
