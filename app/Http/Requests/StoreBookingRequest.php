<?php

namespace App\Http\Requests;

use App\Models\Audience;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'details' => ['required', 'string', 'max:255'],
            'assistance' => ['required', 'numeric', 'min:1'],
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
            'requester.phone' => ['required', 'numeric', 'digits_between:1,16'],
            'requester.identification' => ['required', 'numeric', 'digits_between:1,16'],
            'requester.company_name' => ['required', 'exists:App\Models\Institution,id'],
            'requester.company_role' => ['required', 'string', 'max:255'],
            'requester.academic_unit' => ['required', 'string', 'max:255'],
            'requester.new_institution' => ['required_if:requester.company_name,-1', 'string', 'max:255', 'unique:App\Models\Institution,name'],
            'agreement_contract' => ['required', 'boolean'],
            'agreement_contract_file' => ['exclude_unless:agreement_contract,true', 'required', 'file', 'mimes:pdf'],
        ];
    }

    protected function withValidator(Validator $validator): void
    {
        $validator->sometimes('external_audience_details', 'required', function ($input) {
            if (isset($input->audience) && is_array($input->audience)) {
                // Check if any audience with the name 'external' exists
                return Audience::whereIn('id', $input->audience)
                    ->where('name', 'external')
                    ->exists();
            }

            return false;
        });
    }
}
