<?php

namespace App\Http\Requests;

use App\Enums\Audience;
use App\Enums\Category;
use App\Enums\Grade;
use App\Enums\Language;
use App\Enums\Practice;
use App\Enums\Standard;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|json',
            'title' => 'required|string',
            'published' => 'required|boolean',
            'metadata' => 'array',
            'metadata.audience' => 'enum:'.Audience::class,
            'metadata.category' => 'enum:'.Category::class,
            'metadata.grades' => 'sometimes|array',
            'metadata.grades.*' => 'enum:'.Grade::class,
            'metadata.standards' => 'sometimes|array',
            'metadata.standards.*' => 'enum:'.Standard::class,
            'metadata.practices' => 'sometimes|array',
            'metadata.practices.*' => 'enum:'.Practice::class,
            'metadata.languages' => 'sometimes|array',
            'metadata.languages.*' => 'enum:'.Language::class,
        ];
    }
}
