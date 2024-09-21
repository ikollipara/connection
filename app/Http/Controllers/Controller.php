<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Controllers\HasMiddleware;

class Controller implements HasMiddleware
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function middleware(): array
    {
        return [];
    }
}
