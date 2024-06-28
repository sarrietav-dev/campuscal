<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'details' => ['required', 'string', 'max:255'],
            'assistance' => ['required', 'numeric'],
            'minors' => ['required', 'boolean'],
            'audience' => ['required', 'array', 'min:1'],
            'audience.*' => ['required', 'exists:audiences,id'],
            'appointments' => ['required', 'array', 'min:1'],
            'appointments.*.id' => ['required', 'exists:spaces,id'],
            'appointments.*.date.start' => ['required', 'date', 'before:appointments.*.date.end', 'after:now', 'date_format:Y-m-d H:i:s'],
            'appointments.*.date.end' => ['required', 'date', 'after:appointments.*.date.start', 'after:now', 'date_format:Y-m-d H:i:s'],
            'requester.name' => ['required', 'string', 'max:255'],
            'requester.surname' => ['required', 'string', 'max:255'],
            'requester.email' => ['required', 'email'],
            'requester.phone' => ['required', 'string', 'max:255'],
            'requester.identification' => ['required', 'string', 'max:255'],
            'requester.company_name' => ['required', 'string', 'max:255'],
            'requester.company_role' => ['required', 'string', 'max:255'],
            'requester.academic_unit' => ['required', 'string', 'max:255'],
            'agreement_contract' => ['required', 'boolean'],
            'agreement_contract_file' => ['nullable', 'file', 'mimes:pdf'],
        ];
    }
}
