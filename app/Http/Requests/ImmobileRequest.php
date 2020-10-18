<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImmobileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $isUpdate = $this->isMethod('PUT');

        $rules = [
            'email' => ['required', 'email'],
            'state' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'neighborhood' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:30'],
            'complement' => ['nullable', 'string', 'max:255'],
        ];

        if ($isUpdate) {
            return array_map(function ($rules) {
                array_unshift($rules, 'sometimes');
                return $rules;
            }, $rules);
        }

        return $rules;
    }
}
