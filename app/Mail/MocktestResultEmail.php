<?php

namespace App\Mail;

use App\Models\AiMockTest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MocktestResultEmail extends Mailable
{
    use Queueable, SerializesModels;

    public AiMockTest $test;
    public User $user;
    public array $stats;

    /**
     * Create a new message instance.
     */
    public function __construct(AiMockTest $test, User $user, array $stats)
    {
        $this->test = $test;
        $this->user = $user;
        $this->stats = $stats;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $grade = $this->stats['grade'] ?? 'N/A';
        $percentage = $this->stats['percentage'] ?? 0;
        
        return new Envelope(
            subject: "{$this->test->subject} - {$this->test->topic}: {$grade} ({$percentage}%)",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.mocktest-result',
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
