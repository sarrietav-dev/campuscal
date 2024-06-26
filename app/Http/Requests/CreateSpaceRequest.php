<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateSpaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'numeric'],
            'resources' => ['required', 'array'],
            'resources.*' => ['required', 'exists:space_resources,id'],
            'images' => ['required', 'array'],
            'images.*' => ['required', 'image'],
            'campus_id' => ['required', 'exists:campuses,id'],
        ];
    }
}
