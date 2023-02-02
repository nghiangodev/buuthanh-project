<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckRolePermission
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param \Closure $next
	 * @param $permission
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next, $permission)
	{
		$permissions = \is_array($permission)
			? $permission
			: explode('|', $permission);
		/** @var User $user */
		$user = app('auth')->user();

		if ($user->can($permissions) || $user->hasAnyPermission($permissions)) {
			return $next($request);
		}

		throw UnauthorizedException::forPermissions($permissions);
	}
}
