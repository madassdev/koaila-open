<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEmailUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'current_email' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value != auth()->user()->email) {
                        $fail('The current email is incorrect.');
                    }
                }
            ],
            'new_email' => 'required|email|different:current_email|unique:users,email'
        ];
    }
}