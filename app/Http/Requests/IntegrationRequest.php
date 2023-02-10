<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntegrationRequest extends FormRequest
{
 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->route('type') == 'stripe'){
            return [
                'api_key' => ['required','string'],
            ];
        }

        return [
            'api_key' => ['required','string'],
            'api_secret' => ['required','string']
        ];
    }
}
