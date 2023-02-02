<?php

namespace App\Entities\Core;

use App\Entities\Core\Notification\Notification;
use App\Enums\Communication;
use App\Mail\OtpMail;
use App\Models\User;
use Exception;

class Otp
{
	public $otpText;

	public $username;

	/**
	 * @var null| User
	 */
	private $user;

	/**
	 * Otp constructor.
	 *
	 * @param $username
	 * @param null $user
	 *
	 * @throws Exception
	 */
	public function __construct($username, $user = null)
	{
		$this->username = $username;
		$this->otpText  = random_int(100000, 999999);

		if (! $user) {
			$user = User::query()->userOtp($username);
		}
		$this->user = $user;
	}

	/**
	 * @return Otp
	 */
	public function generate()
	{
		$user = $this->user;

		if ($user) {
			$user->update([
				'otp'            => $this->otpText,
				'otp_expired_at' => now()->addMinutes(5),
			]);
		}

		return $this;
	}

	/**
	 * @param $otp
	 *
	 * @return bool
	 */
	public function validate($otp)
	{
		$user = $this->user->fresh();

		if ($user) {
			return $user
				->where('otp', $otp)
				->where('otp_expired_at', '>=', now()->toDateTimeString())
				->exists();
		}

		return false;
	}

	/**
	 * @return int
	 */
	public function reset()
	{
		$user = $this->user->fresh();

		if ($user) {
			return $user->update([
				'otp'            => null,
				'otp_expired_at' => null,
			]);
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function send()
	{
		try {
			//note: save otp vào database
			$this->generate();

			$user         = $this->user;
			$otpText      = $this->otpText;
			$notification = new Notification($user, $user->otp_types, [
				Communication::EMAIL => (new OtpMail($otpText, $user->name))->onConnection('database')->onQueue('notification'),
			]);

			return $notification->send();
		} catch (Exception $e) {
			return false;
		}
	}

	public function getResponseText()
	{
		$communications = $this->user->otp_types;
		$text           = __('OTP code has been sent to ');

		foreach ($communications as $communication) {
			switch ($communication) {
				case Communication::EMAIL:
					$text .= 'email ' . $this->user->email . ' và ';
					break;
				case Communication::SMS:
					$text .= __('phone') . ' ' . $this->user->phone . '.';
					break;
			}
		}

		return $text;
	}
}
