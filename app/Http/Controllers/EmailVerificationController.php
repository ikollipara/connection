<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var \App\Models\User */
        $user = auth()->user();
        $user->sendEmailVerificationNotification();
        info('Verification link resent for user '.$user->id.' at '.now().'.');

        return view('email-verification.index');
    }

    /**
     * Verify the email address of the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        Log::info('Email verified for user '.$request->user()->id.' at '.now().'.');

        return redirect()->intended(route('home'), 303);
    }
}
