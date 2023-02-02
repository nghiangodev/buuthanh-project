<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class UserLoggedOut
{
	/**
	 * Create the event listener.
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param Logout $event
	 */
	public function handle(Logout $event)
	{
		$user = $event->user;

		// @noinspection PhpParamsInspection
		activity()
			->withProperties(['ip' => request()->ip(), 'user-agent' => request()->userAgent(), 'username' => $user->username])
			->performedOn($user)
			->inLog('Auth')
			->log("{$user->username} đã đăng xuất " . date('d-m-Y H:i:s') . '.');
	}
}
