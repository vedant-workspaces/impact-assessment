<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NgoRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $organisationName;
    public string $userName;

    public function __construct($organisationName, $userName)
    {
        $this->organisationName = $organisationName;
        $this->userName = $userName;
    }

    public function build()
    {
        return $this->subject('NGO Registration Successful')
            ->view('emails.ngo_registered');
    }
}
