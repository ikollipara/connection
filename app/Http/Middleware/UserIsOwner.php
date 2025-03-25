<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

// @codeCoverageIgnoreStart
// covered but isn't detected.
class UserIsOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $resource = null): Response
    {
        $requestUser = $request->route()?->parameter('user');
        $requestRoute = $request->route()?->getName() ?? '';
        if (! $requestUser instanceof User) {
            return to_route($requestRoute, ['me']);
        }
        if (! $requestUser->is(Auth::user())) {
            return to_route($requestRoute, ['me']);
        }

        if ($resource) {
            $requestResource = $request->route()?->parameter($resource);
            if (! ($requestResource instanceof Model && is_callable([$requestResource, 'user']))) {
                return to_route($requestRoute, ['me']);
            }
            if (! $requestResource->user()->is($requestUser)) {
                return to_route($requestRoute, ['me']);
            }
        }

        return $next($request);
    }
}
// @codeCoverageIgnoreEnd
