<?php

namespace App\Http\Requests;

use App\Models\Contract;
use App\Models\Immobile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $documentSize =
            $this->input('document_type') === Contract::DOCUMENT_TYPE_ENTITY
                ? Contract::DOCUMENT_TYPE_ENTITY_LENGTH
                : Contract::DOCUMENT_TYPE_PERSON_LENGTH;

        return [
            'receiver_email' => ['required', 'string', 'max:255', 'email'],
            'receiver_name' => ['required', 'string', 'max:255'],
            'document_type' => [
                'required',
                'string',
                Rule::in([
                    Contract::DOCUMENT_TYPE_ENTITY,
                    Contract::DOCUMENT_TYPE_PERSON,
                ]),
            ],
            'document_number' => [
                'required',
                'string',
                'size:' . $documentSize,
                'cpf_cnpj',
            ],
        ];
    }
}
