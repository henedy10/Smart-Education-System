<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendPasswordResetLink extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;

    public function __construct($token)
    {
        $this->resetUrl = url("/reset-password/{$token}");
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Password Reset Link',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-password',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
