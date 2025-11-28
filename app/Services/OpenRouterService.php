<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    protected $baseUrl = 'https://openrouter.ai/api/v1';
    protected $apiKey;
    protected $model = 'x-ai/grok-4.1-fast:free';

    public function __construct()
    {
        $this->apiKey = env('OPENROUTER_API_KEY');
    }

    public function validateTopic($subject, $topic)
    {
        $prompt = "You are an academic curriculum validator. Check if the User's 'Topic' actually belongs to the 'Subject'.
        If the subject name is informal (e.g. 'Maths'), suggest the formal name ('Mathematics').
        If the topic is misspelled or slightly off, suggest the correct one.
        If the topic is completely unrelated, return valid: false.
        
        Input: { Subject: '$subject', Topic: '$topic' }
        
        Output strictly valid JSON: 
        { 
            'valid': boolean, 
            'corrected_subject': string (optional), 
            'corrected_topic': string (optional), 
            'reason': string (if invalid) 
        }";

        return $this->chatRequest($prompt);
    }

    public function generateTest($config)
    {
        $prompt = "Act as a senior exam setter for {$config['exam']}. Create a mock test.
        Constraints:
        - Subject: {$config['subject']}
        - Topic Focus: {$config['topic']}
        - Count: {$config['count']}
        - Difficulty: {$config['difficulty']}
        
        Format: Return strictly valid JSON with this structure:
        {
            'questions': [
                {
                    'question': 'Question text',
                    'options': ['A', 'B', 'C', 'D'],
                    'correct_index': 0 (0-3),
                    'explanation': 'Detailed explanation'
                }
            ]
        }";

        return $this->chatRequest($prompt);
    }

    protected function chatRequest($prompt)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer' => config('app.url'),
                'X-Title' => config('app.name'),
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                // Clean markdown code blocks if present
                $content = str_replace(['```json', '```'], '', $content);
                return json_decode($content, true);
            }

            Log::error('OpenRouter API Error: ' . $response->body());
            return ['error' => 'API Error: ' . $response->status() . ' ' . $response->body()];
        } catch (\Exception $e) {
            Log::error('OpenRouter Exception: ' . $e->getMessage());
            return ['error' => 'Exception: ' . $e->getMessage()];
        }
    }
}
