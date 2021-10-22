<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;
use Illuminate\Validation\Rule;

class CreateRiskProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'age' => ['required', 'integer', 'min:0'],
            'dependents' => ['required', 'integer', 'min:0'],
            'house.ownership_status' => ['sometimes', 'required', Rule::in(['mortgaged', 'owned'])],
            'income' => ['required', 'integer', 'min:0'],
            'marital_status' => ['required', Rule::in(['single', 'married'])],
            'risk_questions' => ['required', 'array', 'min:3', 'max:3'],
            'risk_questions.*' => ['required', 'integer', 'min:0', 'max:1'],
            'vehicle.year' => ['sometimes', 'required', 'integer', 'digits:4']
        ];
    }
}
