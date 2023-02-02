<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification implements ShouldQueue
{
	use Queueable;

	private $message;

	private $level;

	/**
	 * Create a new notification instance.
	 *
	 * @param $message
	 * @param $level
	 */
	public function __construct($message, $level)
	{
		$this->message = $message;
		$this->level   = $level;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 *
	 * @return array
	 */
	public function via($notifiable)
	{
		$isUserConnected = \Illuminate\Support\Facades\Redis::connection()->pubsub('CHANNELS', "private-user-{$notifiable->id}");

		return $isUserConnected ? ['broadcast', 'database'] : ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 *
	 * @SuppressWarnings(PHPMD)
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		return (new MailMessage)
			->from(config('mail.from.address'), config('app.name'))
			->subject('Thông tin thay đổi ngưởi dùng')
			->line($this->message);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 *
	 * @SuppressWarnings(PHPMD)
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			'message' => $this->message,
			'level'   => $this->level,
		];
	}

	/**
	 * Get the broadcastable representation of the notification.
	 *
	 * @param mixed $notifiable
	 *
	 * @SuppressWarnings(PHPMD)
	 * @return BroadcastMessage
	 */
	public function toBroadcast($notifiable)
	{
		return new BroadcastMessage([
			'message'     => $this->message,
			'level'       => $this->level,
			'notified_at' => now()->toDateTimeString(),
		]);
	}
}
