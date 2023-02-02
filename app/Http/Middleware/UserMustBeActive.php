<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMustBeActive
{
	/**
	 * Handle an incoming request.
	 *
	 * @param Request $request
	 * @param Closure $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = $request->user();

		if ($user && $user->isActive()) {
			return $next($request);
		}
		$request->session()->invalidate();

		abort(403);
	}
}
