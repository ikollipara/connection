<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserSettingsRequest extends FormRequest
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
            "receive_weekly_digest" => "sometimes|accepted",
            "receive_comment_notifications" => "sometimes|accepted",
            "receive_new_follower_notifications" => "sometimes|accepted",
            "receive_follower_notifications" => "sometimes|accepted",
        ];
    }
}
