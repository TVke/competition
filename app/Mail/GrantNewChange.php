<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GrantNewChange extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 */
	public function __construct()
	{

	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$address = env('MAIL_FROM_ADDRESS');
		$name = env('MAIL_FROM_NAME');
		$subject = __('app.new-change-mail-subject');

		return $this->view('mail.newChange')
			->from($address, $name)
			->subject($subject);
	}
}
