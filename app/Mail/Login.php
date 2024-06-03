<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class Login extends Mailable
{
    use Queueable, SerializesModels;

    public string $login_link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->login_link = URL::temporarySignedRoute(
            "login.show",
            now()->addHour(),
            [
                "user" => $user,
            ],
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env("MAIL_FROM_ADDRESS"))
            ->subject("Login to conneCTION")
            ->view("mail.login", [
                "login_link" => $this->login_link,
            ]);
    }
}
