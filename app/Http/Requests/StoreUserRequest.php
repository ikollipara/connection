<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "first_name" => "required|string",
            "last_name" => "required|string",
            "email" => "required|email|unique:users,email",
            "grades" => "present",
            "is_preservice" => "sometimes|accepted",
            "school" => "required_without:is_preservice|string",
            "years_of_experience" =>
                "required_without:is_preservice|integer|min:0",
            "subject" => "required|string",
            "avatar" => "image|nullable",
            "bio" => "required|json",
            "consented" => "sometimes|accepted",
        ];
    }
}
