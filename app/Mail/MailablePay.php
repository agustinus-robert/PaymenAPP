<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class MailablePay extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($pay)
    {
        $this->pay = $pay;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            subject: 'Usarname Dan Login anda',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $arr['email'] = $this->pay['email'];
        $arr['firstName'] = $this->pay['first_name'];
        $arr['username'] = $this->pay['username'];
        $arr['password'] = $this->pay['password'];

        return new Content(
            view: 'notify.mail',
            with: $arr 
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
