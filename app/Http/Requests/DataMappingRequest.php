<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataMappingRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'stripe_id'=>['required','string'],
            'usage_tracking_id'=>['required','string'],
            'email'=>['required','string'],
        ];
    }
}
