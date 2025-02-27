<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inviteEmail;
    public $token;
    public $activationUrl;

    public function __construct($inviteEmail, $token)
    {
        $this->inviteEmail = $inviteEmail;
        $this->token = $token;
        $this->activationUrl = url('/activate-account/' . $token);
    }

    public function build()
    {
        return $this->subject('Welcome to Whello - Account Activation')
                    ->markdown('emails.user-invitation');
    }
}
