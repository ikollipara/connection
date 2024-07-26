<?php

namespace App\Http\Requests;

use App\Enums\Audience;
use App\Enums\Category;
use App\Enums\Grade;
use App\Enums\Language;
use App\Enums\Practice;
use App\Enums\Standard;
use App\Enums\StandardGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
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
            "q" => "string|nullable",
            "type" => [Rule::in(["post", "collection"]), "nullable"],
            "categories.*" => "sometimes|enum:" . Category::class,
            "audiences.*" => "sometimes|enum:" . Audience::class,
            "standards.*" => "sometimes|enum:" . Standard::class,
            "grades.*" => "sometimes|enum:" . Grade::class,
            "practices.*" => "sometimes|enum:" . Practice::class,
            "languages.*" => "sometimes|enum:" . Language::class,
            "standard_groups.*" => "sometimes|enum:" . StandardGroup::class,
            "likes_count" => "sometimes|integer|min:0",
            "views_count" => "sometimes|integer|min:0",
        ];
    }
}
