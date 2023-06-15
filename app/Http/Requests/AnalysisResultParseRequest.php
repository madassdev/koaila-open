<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnalysisResultParseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // api_auth_key must be setup in .env and value must be exact as value passed in request. 
        return config('app.api_auth_key') && request()->api_auth_key == config('app.api_auth_key');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'required|mimes:json,csv',
            'config_id' => 'required|numeric|exists:customers,config_id'
        ];
    }
}