<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FirstEmail extends Mailable
{
    use Queueable, SerializesModels;
    protected $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("invite@scoutium.com")->view('email-template', ['token' => $this->token]);
    }
}
