<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserIsOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $resource = null): Response
    {
        $requestUser = $request->route()->parameter('user');
        if (! $requestUser?->is(Auth::user())) {
            return to_route($request->route()->getName(), ['me']);
        }

        if ($resource) {
            $requestResource = $request->route()->parameter($resource);
            if (! $requestResource?->user()->is($requestUser)) {
                return to_route($request->route()->getName(), ['me']);
            }
        }

        return $next($request);
    }
}
