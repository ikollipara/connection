<?php

namespace App\Http\Handlers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateUserConsentHandler extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            "consented" => "sometimes|accepted",
        ]);

        $request->user()->consented = isset($validated["consented"]);
        $successful = $request->user()->save();

        if (!$successful) {
            return back()->with(
                "error",
                __("An error occurred while updating your consent."),
            );
        }

        return back()->with("success", __("Your consent has been updated."));
    }
}
