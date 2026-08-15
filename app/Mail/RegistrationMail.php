<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $subjectText,
        public string $bodyText
    ) {
    }

    // メール件名を設定する
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectText
        );
    }

    // メール本文のBladeを指定する
    public function content(): Content
    {
        return new Content(
            view: 'mail.registration'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
