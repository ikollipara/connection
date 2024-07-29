<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Mail\Login;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("auth.login.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        /** @var string */
        $email = mb_strtolower($request->safe()->email, "UTF-8");
        abort_unless(
            $user = User::query()
                ->where("email", $email)
                ->first(),
            404,
            "User with given email not found.",
        );

        Mail::to($email)->queue(new Login($user));

        return redirect()
            ->route("login.create")
            ->setStatusCode(303)
            ->with("success", __("Please check your inbox to login."));
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        abort_unless($request->hasValidSignature(), 403, "This link has expired. Please request a new one.");

        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
        }

        auth()->loginUsingId($user->id, true);
        session()->regenerate();

        return redirect()
            ->route("home")
            ->setStatusCode(303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()
            ->route("login.create")
            ->setStatusCode(303);
    }
}
