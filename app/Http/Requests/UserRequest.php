<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, string|array<string>>
     */
    public function rules()
    {
        return [
            'email' => 'email',
            'first_name' => 'string',
            'last_name' => 'string',
            'school' => 'string',
            'subject' => 'string',
            'grades' => 'array',
            'avatar' => 'image',
            'bio' => 'json',
        ];
    }
}
