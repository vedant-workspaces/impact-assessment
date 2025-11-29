<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $fullName;
    public string $userName;

    public function __construct($fullName, $userName)
    {
        $this->fullName = $fullName;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('Member Registration Successful')
            ->view('emails.member_registered');
    }
}