<?php

uses()->group('arch');


arch('Ensure all models extend Eloquent Model')
    ->expect('App\Models')
    ->toBeClasses()
    ->ignoring('App\Models\Concerns')
    ->toExtend('Illuminate\Database\Eloquent\Model')
    ->ignoring('App\Models\Concerns');


arch('Ensure Controllers only extend Controller')
    ->expect('App\Http\Controllers')
    ->toBeClasses()
    ->toExtend('App\Http\Controllers\Controller');


arch('Ensure `back` is not used. Use `session_back` instead.')
    ->expect(['back'])
    ->not->toBeUsed();
