<?php

namespace App\Http\Handlers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateUserConsentHandler extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'consented' => 'sometimes|accepted',
        ]);

        $request->user()->consented = isset($validated['consented']);
        $successful = $request->user()->save();

        if (!$successful) {
            return session_back()->with(
                "error",
                __("An error occurred while updating your consent."),
            );
        }

        return session_back()->with("success", __("Your consent has been updated."));
    }
}
