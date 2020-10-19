<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest
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
        return [
            'search' => 'string',
            'per_page' => 'numeric|min:1|max:200',
            'sort' => 'array',
            'sort.*.column' => 'string',
            'sort.*.desc' => 'boolean',
        ];
    }

    public function search()
    {
        $search = $this->input('search');
        if (!$search) {
            return null;
        }

        $escapePercent = str_replace('%', '\%', $search);

        $words = explode(' ', $escapePercent);

        return array_map(function ($word) {
            return '%' . $word . '%';
        }, $words);
    }
}
