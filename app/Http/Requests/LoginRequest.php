<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// @codeCoverageIgnoreStart
// We ignore the coverage since its tested by AuthenticatedUserControllerTest.php
// But Pest's coverage can't detect that.
class LoginRequest extends FormRequest
{
    protected $redirectRoute = 'login';

    public function rules()
    {
        return [
            'email' => 'email|required|exists:users,email',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'The email you entered does not exist.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
        ];
    }
}
// @codeCoverageIgnoreEnd
