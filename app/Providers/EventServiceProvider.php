<?php

namespace App\Providers;

use App\Listeners\UserLoggedIn;
use App\Listeners\UserLoggedOut;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		Login::class => [
			UserLoggedIn::class,
		],
		Logout::class => [
			UserLoggedOut::class,
		],
	];

	/**
	 * Register any events for your application.
	 */
	public function boot()
	{
		parent::boot();

		//
	}
}
