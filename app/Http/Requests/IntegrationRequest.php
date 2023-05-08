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
        switch($this->route('type')){
            case 'stripe':
                return [
                'key' => ['required','string'],
                ];
            default:
                return [
                    'key' => ['required','string'],
                    'secret' => ['required','string']
                ];
        }
    }
}

