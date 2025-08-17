<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountActivationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->url = route('account_activation', $user->registration_token);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.activation')->to($this->user->email, $this->user->username)->subject('Activar cuenta gestor juegos');
    }
}
