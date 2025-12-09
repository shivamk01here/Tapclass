<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSubmittedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $paymentRequest;

    public function __construct($paymentRequest)
    {
        $this->paymentRequest = $paymentRequest;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Submitted for Verification - HTC',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-submitted',
        );
    }
}
