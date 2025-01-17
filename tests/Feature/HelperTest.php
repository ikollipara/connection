<?php

use Illuminate\Http\RedirectResponse;

use function Pest\Laravel\get;

it('should return the last url in the session', function () {
    get("/");

    $redirect = session_back();

    expect($redirect)->toBeInstanceOf(RedirectResponse::class);
});
