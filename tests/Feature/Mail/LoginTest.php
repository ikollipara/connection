<?php

use App\Mail\Login;
use App\Models\User;

covers(Login::class);

it('should create and build a login mail', function () {
    /** @var User */
    $user = User::factory()->createOne();

    $login = new Login($user);
    $login->build();

    expect($login->markdown)->not->toBeNull();
});
