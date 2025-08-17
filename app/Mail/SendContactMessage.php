<?php

namespace App\Mail;

use http\Env\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Requests\ContactMessageRequest;

class SendContactMessage extends Mailable
{
    use Queueable, SerializesModels;


    public $request;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactMessageRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->request->get('subject');
        $name = $this->request->get('name');
        $email = $this->request->get('email');
        $enterprise = $this->request->get('enterprise');
        $text = $this->request->get('text');
        return $this
            ->from($this->request->get('email'))
            ->subject($this->request->get('subject'))
            ->markdown('mails.contact_message')
            ->with(compact('subject', 'text', 'email', 'enterprise', 'name'));
    }
}
