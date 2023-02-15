<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
{
 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->route('type') == 'aha_moment'){
            return [
                'name' => ['required','string'],
                'event' => ['required','string'],
            ];
        }
    }
}
