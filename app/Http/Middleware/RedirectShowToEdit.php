<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RedirectShowToEdit
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
		$currentRouteName  = $request->route()->getName();
		$currentRouteNames = explode('.', $currentRouteName);
		$route             = $currentRouteNames[0];

		if (Str::contains($currentRouteName, 'show')) {
			$singularRouteName = Str::singular($route);

			return redirect()->route("{$route}.edit", [$singularRouteName => $request->route()->parameters[$singularRouteName]]);
		}

		return $next($request);
	}
}
