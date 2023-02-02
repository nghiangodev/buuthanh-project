<?php

namespace App\Entities\Core\Notification;

use App\Enums\Communication;
use App\Models\User;

class Notification
{
	private $communications;

	/**
	 * @var array
	 */
	private $contents;

	/**
	 * @var User
	 */
	private $user;

	public function __construct($user, $communications, $contents)
	{
		$this->communications = $communications;
		$this->user           = $user;
		$this->contents       = $contents;
	}

	/**
	 * @return bool
	 */
	public function send()
	{
		$user           = $this->user;
		$communications = $this->communications;
		$result         = null;

		foreach ($communications as $communication) {
			switch ($communication) {
				case Communication::SMS:
					break;
				case Communication::EMAIL:
					if (isset($this->contents[Communication::EMAIL])) {
						$emailNotification = new EmailNotification($user, $this->contents[Communication::EMAIL]);
						$result            = $emailNotification->send();
					}

					break;
			}
		}

		return $result;
	}
}
