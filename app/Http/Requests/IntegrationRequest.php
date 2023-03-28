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
        if($this->route('type') =='stripe'){
            return [
                'key' => ['required','string'],
            ];
        }
        return [
            'key' => ['required','string'],
            'secret' => ['required','string']
        ];
    }
}

