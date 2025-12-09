<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $botToken;
    protected string $mocktestGroupId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token', '');
        $this->chatId = config('services.telegram.group_id', '');
        $this->mocktestGroupId = config('services.telegram.mocktest_group_id', '');
    }

    /**
     * Send a notification message to a specific chat ID
     *
     * @param string $message The message to send
     * @param string|null $chatId Optional chat ID (uses default if null)
     * @return bool
     */
    public function sendNotification(string $message, ?string $chatId = null): bool
    {
        $targetChatId = $chatId ?? $this->chatId;

        if (empty($this->botToken) || empty($targetChatId)) {
            Log::warning('Telegram notification skipped: Bot token or chat ID not configured');
            return false;
        }

        try {
            $response = Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
                'chat_id' => $targetChatId,
                'text' => $message,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);

            if ($response->successful()) {
                Log::info('Telegram notification sent successfully');
                return true;
            }

            Log::error('Telegram notification failed', [
                'status' => $response->status(),
                'response' => $response->json(),
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('Telegram notification error', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Send a new user registration notification
     *
     * @param \App\Models\User $user The newly registered user
     * @return bool
     */
    public function sendRegistrationNotification(\App\Models\User $user): bool
    {
        $roleEmoji = match($user->role) {
            'student' => '🎓',
            'tutor' => '👨‍🏫',
            'parent' => '👨‍👩‍👧',
            'admin' => '🔐',
            default => '👤',
        };

        $message = "🎉 <b>New User Registration!</b>\n\n";
        $message .= "{$roleEmoji} <b>Role:</b> " . ucfirst($user->role) . "\n";
        $message .= "👤 <b>Name:</b> {$user->name}\n";
        $message .= "📧 <b>Email:</b> {$user->email}\n";
        $message .= "📅 <b>Time:</b> " . now()->format('d M Y, h:i A') . "\n\n";
        $message .= "━━━━━━━━━━━━━━━━━━";

        return $this->sendNotification($message);
    }

    /**
     * Send mock test completion notification
     * 
     * @param \App\Models\User $user
     * @param array $resultStats
     * @param \App\Models\AiMockTest $test
     * @return bool
     */
    public function sendMocktestNotification(\App\Models\User $user, array $resultStats, \App\Models\AiMockTest $test): bool
    {
        if (empty($this->mocktestGroupId)) {
            Log::warning('Telegram mocktest notification skipped: Mocktest group ID not set');
            return false; 
        }

        $message = "📝 <b>New Mock Test Attempt</b>\n\n";
        $message .= "👤 <b>Name:</b> {$user->name}\n";
        $message .= "📱 <b>Phone:</b> " . ($user->phone ?? 'N/A') . "\n";
        $message .= "📧 <b>Email:</b> {$user->email}\n";
        $message .= "📅 <b>Joined:</b> " . $user->created_at->format('d M Y') . "\n\n";
        
        $message .= "📊 <b>Result Overview:</b>\n";
        $message .= "📚 <b>Subject:</b> {$test->subject}\n";
        $message .= "🎯 <b>Score:</b> {$resultStats['correct']}/{$resultStats['total']} ({$resultStats['percentage']}%)\n";
        $message .= "🏆 <b>Grade:</b> {$resultStats['grade']}\n\n";
        $message .= "━━━━━━━━━━━━━━━━━━";

        return $this->sendNotification($message, $this->mocktestGroupId);
    }

    /**
     * Send payment notification with screenshot
     * 
     * @param \App\Models\AiPaymentRequest $payment
     * @return bool
     */
    public function sendPaymentNotification(\App\Models\AiPaymentRequest $payment): bool
    {
        if (empty($this->mocktestGroupId)) { // Using same group for payments for now
            Log::warning('Telegram payment notification skipped: Group ID not set'); 
            return false;
        }

        $user = $payment->user;
        $roleEmoji = match($user->role) {
            'student' => '🎓',
            'tutor' => '👨‍🏫',
            'parent' => '👨‍👩‍👧',
            'admin' => '🔐',
            default => '👤',
        };

        $caption = "💸 <b>New Payment Received!</b>\n\n";
        $caption .= "{$roleEmoji} <b>User:</b> {$user->name}\n";
        $caption .= "📧 <b>Email:</b> {$user->email}\n";
        $caption .= "📱 <b>Phone:</b> " . ($user->phone ?? 'N/A') . "\n";
        $caption .= "💳 <b>Plan:</b> " . ucfirst($payment->plan) . "\n";
        $caption .= "💰 <b>Amount:</b> ₹{$payment->amount}\n";
        $caption .= "🔢 <b>UTR:</b> {$payment->utr}\n";
        $caption .= "📅 <b>Date:</b> " . $payment->created_at->format('d M Y, h:i A') . "\n\n";
        $caption .= "Please verify and approve in admin panel.";

        // Send Photo
        try {
            $photoPath = storage_path('app/public/' . $payment->screenshot_path);
            
            // If file doesn't exist locally (e.g. S3), use URL. For now assuming local public storage.
            // If using standard storage:link, it should be in storage/app/public
            
            $response = Http::attach(
                'photo', file_get_contents($photoPath), 'screenshot.jpg'
            )->post("https://api.telegram.org/bot{$this->botToken}/sendPhoto", [
                'chat_id' => $this->mocktestGroupId,
                'caption' => $caption,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful()) {
                Log::info('Telegram payment notification sent');
                return true;
            }

            Log::error('Telegram payment notification failed', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);
            
            // Fallback to text only if photo fails
            return $this->sendNotification($caption, $this->mocktestGroupId);

        } catch (\Exception $e) {
            Log::error('Telegram photo send error', ['error' => $e->getMessage()]);
            // Fallback
            return $this->sendNotification($caption, $this->mocktestGroupId);
        }
    }
}
