<?php

namespace App\Mail;

use App\Player;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class inviteFriend extends Mailable
{
    use Queueable, SerializesModels;

	public $friendId,$token;

	/**
	 * Create a new message instance.
	 *
	 * @param $friendId
	 * @param $token
	 */
    public function __construct($friendId,$token)
    {
        $this->friendId = $friendId;
	    $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	$friend = Player::where('id',$this->friendId)->first();
	    $address = $friend->email;
	    $name = $friend->first_name." ".$friend->last_name;
	    $subject = __('app.friend-mail-subject',['friend'=>$name]);
	    $token = $this->token;

	    return $this->view('mail.friendInvite',compact(['name','token']))
		    ->from($address, $name)
		    ->subject($subject);
    }
}
