<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string|array<string>>
     */
    public function rules()
    {
        return [
            "email" => "email|required|exists:users,email",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            "email.exists" => "The email you entered does not exist.",
            "email.required" => "Please enter your email address.",
            "email.email" => "Please enter a valid email address.",
        ];
    }
}
