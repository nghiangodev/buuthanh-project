<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
	use Queueable, SerializesModels;

	private $otp;

	private $name;

	/**
	 * Create a new message instance.
	 *
	 * @param $otp
	 * @param $name
	 */
	public function __construct($otp, $name)
	{
		$this->otp  = $otp;
		$this->name = $name;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('mails.otp', [
			'otp'  => $this->otp,
			'name' => $this->name,
		]);
	}
}
