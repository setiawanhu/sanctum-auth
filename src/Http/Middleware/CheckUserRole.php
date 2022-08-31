<?php

namespace Hu\Auth\Http\Middleware;

use Closure;
use Hu\Auth\AuthModel;
use Hu\Auth\Exceptions\InvalidRoleException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param array $roles
     * @return mixed
     * @throws InvalidRoleException
     */
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        $roles = collect($roles);
        $authenticated = AuthModel::authenticated();

        if ($roles->contains(Str::lower($authenticated->role->name))) {
            return $next($request);
        }

        throw new InvalidRoleException(implode(' / ', $roles->toArray()), $authenticated->role->name);
    }
}
