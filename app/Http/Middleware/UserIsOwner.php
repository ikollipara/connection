<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Model;
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
        if (! $requestUser instanceof User) {
            return to_route($request->route()->getName(), ['me']);
        }
        if (! $requestUser->is(Auth::user())) {
            return to_route($request->route()->getName(), ['me']);
        }

        if ($resource) {
            $requestResource = $request->route()->parameter($resource);
            if (! ($requestResource instanceof Model && is_callable([$requestResource, 'user']))) {
                return to_route($request->route()->getName(), ['me']);
            }
            if (! $requestResource->user()->is($requestUser)) {
                return to_route($request->route()->getName(), ['me']);
            }
        }

        return $next($request);
    }
}
