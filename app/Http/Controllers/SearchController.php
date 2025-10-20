<?php

namespace App\Http\Controllers;

use App\Enums\Grade;
use App\Enums\Standard;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $key_array_func = fn ($case) => [str($case->value), $case->label];
        $grades = collect(Grade::cases())->map($key_array_func);
        $standards = collect(Standard::cases())->map($key_array_func);

        return view('web.search.empty', [
            'grades' => $grades,
            'standards' => $standards,
        ]);
    }
}
