<?php

pest()->group('arch');

arch('PHP Preset')->preset()->php();
arch('Laravel Preset')
    ->preset()
    ->laravel()
    ->ignoring([
        'App\Http\Controllers\EmailVerificationController',
        'App\Http\Middleware\RedirectIfAuthenticated',
        'App\Enums',
    ]);
arch('Security Preset')->preset()->security();

arch('(My) Strict Preset')->preset()->custom('myStrict', function (array $userNamespaces) {
    $expectations = [];
    foreach ($userNamespaces as $namespace) {
        $expectations[] = expect($namespace)->classes()->not->toHaveProtectedMethodsBesides(['booted']);
        $expectations[] = expect($namespace)->classes()->not->toBeAbstract();
        $expectations[] = expect($namespace)->toUseStrictTypes();
        $expectations[] = expect($namespace)->toUseStrictEquality();
    }

    $expectations[] = expect([
        'sleep',
        'usleep',
    ])->not->toBeUsed();

    return $expectations;
});

arch()->preset()->myStrict();
