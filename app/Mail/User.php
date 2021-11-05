<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class User extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_data;

    public function __construct($mail_data)
    {

        $this->mail_data = $mail_data;

    }

    public function build()
    {
        return $this->subject('Truwork - děkujeme že jste nás kontaktovali')->view('emails.user');
    }
}
