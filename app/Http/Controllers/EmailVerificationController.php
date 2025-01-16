<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

final class EmailVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(): View
    {
        /** @var \App\Models\User */
        $user = auth()->user();
        $user->sendEmailVerificationNotification();
        info('Verification link resent for user ' . $user->id . ' at ' . now() . '.');

        return view('email-verification.index');
    }

    /**
     * Verify the email address of the user.
     *
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();
        Log::info('Email verified for user ' . $request->user()->id . ' at ' . now() . '.');

        return redirect()->intended(route('home'), 303);
    }
}
