<?php
/**
 * User: ADMIN
 * Date: 5/15/2019 11:00 AM.
 */

namespace App\Entities\Core\Notification;

use App\Models\User;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class EmailNotification
{
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @var Mailable
	 */
	private $message;

	public function __construct($user, $message)
	{
		$this->user    = $user;
		$this->message = $message;
	}

	public function send()
	{
		$email = $this->user->email;

		return Mail::to($email)->queue($this->message);
	}
}
