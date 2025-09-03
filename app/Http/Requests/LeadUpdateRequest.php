<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\LeadStatus;


class LeadUpdateRequest extends FormRequest
{
public function authorize(): bool { return true; }


public function rules(): array
{
return [
'name' => 'sometimes|required|string|max:255',
'message' => 'sometimes|required|string',
'email' => 'nullable|email|required_without:phone',
'phone' => 'nullable|string|required_without:email|max:50',
'status' => ['sometimes', Rule::in(LeadStatus::values())],
'source_id' => 'nullable|exists:sources,id',
];
}
}