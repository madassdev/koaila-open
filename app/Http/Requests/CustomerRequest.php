<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'config_uuid' => ['required','string', 'exists:configurations,uuid'],
            'stripe_id'=>['required','string'],
            'usage_tracking_id'=>['required','string'],
            'email'=>['required','string'],
        ];
    }
}
