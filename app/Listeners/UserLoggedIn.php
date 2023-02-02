<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;

class UserLoggedIn
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
	 * @param Login $event
	 */
	public function handle(Login $event)
	{
		/** @var User $user */
		$user                = $event->user;
		$user->last_login_at = now()->toDateTimeString();
		$user->last_login_ip = request()->ip();
		$user->update();

		// @noinspection PhpParamsInspection
		activity()
			->withProperties(['ip' => request()->ip(), 'user-agent' => request()->userAgent(), 'username' => $user->username])
			->performedOn($user)
			->inLog('Auth')
			->log("{$user->username} đã đăng nhập " . date('d-m-Y H:i:s') . '.');
	}
}
