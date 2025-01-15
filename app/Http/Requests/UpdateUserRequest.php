<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore(auth()->id()),
            ],
            'is_preservice' => 'sometimes|accepted',
            'school' => 'sometimes|required_without:is_preservice|string',
            'year' => 'sometimes|required_without:is_preservice|integer|min:0',
            'subject' => 'sometimes|string',
            'grades' => 'sometimes',
            'bio' => 'json',
        ];
    }
}
