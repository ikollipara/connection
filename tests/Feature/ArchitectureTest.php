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
// arch('Strict Preset')
//     ->preset()
//     ->strict()
//     ->ignoring([
//         'App\Http\Controllers\Controller',
//     ])->markTestSkipped('Build Coverage First');
