<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->user->role) {
            'student' => 'Welcome to Home Tutor Consultancy - Your Learning Journey Begins!',
            'tutor' => 'Welcome to Home Tutor Consultancy - Start Teaching Today!',
            'parent' => 'Welcome to Home Tutor Consultancy - Empower Your Child\'s Education!',
            default => 'Welcome to Home Tutor Consultancy!',
        };

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = match($this->user->role) {
            'student' => 'emails.welcome-student',
            'tutor' => 'emails.welcome-tutor',
            'parent' => 'emails.welcome-parent',
            default => 'emails.welcome-student',
        };

        return new Content(
            view: $view,
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
