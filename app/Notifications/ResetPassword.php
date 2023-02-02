<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class ResetPassword.
 *
 * @SuppressWarnings(PHPMD)
 */
class ResetPassword extends Notification
{
	use Queueable;

	private $user;

	private $newPassword;

	/**
	 * @param $user
	 * @param $newPassword
	 */
	public function __construct($user, $newPassword)
	{
		$this->user        = $user;
		$this->newPassword = $newPassword;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		return (new MailMessage)
			->from(config('mail.from.address'), config('mail.from.name'))
			->subject(__('Password reset notification'))
			->action(__('Login'), route('home'))
			->line(__('The new account password is') . ' ' . $this->newPassword);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			//
		];
	}
}
