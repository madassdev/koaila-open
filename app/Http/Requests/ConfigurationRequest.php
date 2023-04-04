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
        return [
            'aha_moment.*.name' => ['required','string'],
            'aha_moment.*.event' => ['required','string'],
            'features.*.name' => ['required','string'],
            'features.*.event' => ['required','string'],
            'conversion_channel.*.name' => ['required','string'],
            'conversion_channel.*.event' => ['required','string'],
            'pricing_page_url' => ['required','string'],
            'api_token' => ['string'],
        ];
    }
}
