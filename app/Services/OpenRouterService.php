<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config; // Added for Config::get

class OpenRouterService
{
    protected $baseUrl = 'https://openrouter.ai/api/v1';
    protected $apiKey;
    protected $model = 'x-ai/grok-4.1-fast:free';
    protected $siteUrl; // Added property
    protected $siteName; // Added property

    public function __construct()
    {
        $this->apiKey = env('OPENROUTER_API_KEY');
        $this->siteUrl = Config::get('app.url'); // Initialized property
        $this->siteName = Config::get('app.name'); // Initialized property
    }

    public function validateTopic($exam, $subject, $topic)
    {
        // Use default model (Grok) as requested
        $model = $this->model;

        $prompt = "You are an expert academic counselor. A student wants to take a mock test for the exam '$exam'.
        They have entered the Subject: '$subject' and Topic: '$topic'.
        
        Task:
        1. Verify if this subject and topic are valid and relevant for the '$exam'.
        2. If valid, standardize the names (e.g., 'phy' -> 'Physics', 'thermo' -> 'Thermodynamics').
        3. If invalid, explain why briefly.
        
        Return ONLY a JSON object:
        {
            \"valid\": true/false,
            \"corrected_subject\": \"Standardized Subject Name\",
            \"corrected_topic\": \"Standardized Topic Name\",
            \"reason\": \"Error message if invalid, or null if valid\"
        }";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer' => $this->siteUrl,
                'X-Title' => $this->siteName,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.3, 
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';
                
                // Extract JSON from potential markdown code blocks
                if (preg_match('/\{.*\}/s', $content, $matches)) {
                    return json_decode($matches[0], true);
                }
                
                $json = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('OpenRouter JSON Parse Error: ' . $content);
                    return ['error' => 'Failed to parse AI response. Raw: ' . substr($content, 0, 100)];
                }
                return $json;
            }

            Log::error('OpenRouter API Error: ' . $response->body());
            return ['error' => 'AI Service Unavailable: ' . $response->status() . ' - ' . $response->body()];

        } catch (\Exception $e) {
            Log::error('OpenRouter Exception: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
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

    public function validateExam($examName)
    {
        // Use Gemini Flash for speed and better reasoning on partial matches
        $model = "google/gemini-2.0-flash-001";
        
        $prompt = "User Input: '$examName'.
        
        Task: Identify the exam the user is referring to.
        
        Rules:
        1. If it's a clear abbreviation or exact name (e.g., 'JEE', 'SAT', 'UPSC'), return 'match_type': 'exact' and the standardized name.
        2. If it's a partial keyword (e.g., 'nasa', 'bank', 'police'), find up to 5 REAL exams that contain this word or are relevant. Return 'match_type': 'ambiguous' and list them.
        3. If 'nasa' is entered, suggest things like 'NASA Entrance Exam' (if exists), 'Astronomy Olympiad', 'NEST', etc. Be helpful, not strict.
        4. Only return 'valid': false if the input is complete gibberish (e.g., 'asdfgh').

        Return ONLY a JSON object:
        {
            \"valid\": true/false,
            \"match_type\": \"exact\" or \"ambiguous\",
            \"exam\": \"Standardized Name\" (if exact),
            \"suggestions\": [\"Option 1\", \"Option 2\", ...] (if ambiguous, max 5),
            \"reason\": \"Error message if invalid\"
        }";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer' => $this->siteUrl,
                'X-Title' => $this->siteName,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.3,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';
                
                if (preg_match('/\{.*\}/s', $content, $matches)) {
                    return json_decode($matches[0], true);
                }
                
                $json = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('OpenRouter JSON Parse Error: ' . $content);
                    return ['error' => 'Failed to parse AI response.'];
                }
                return $json;
            }

            Log::error('OpenRouter API Error: ' . $response->body());
            return ['error' => 'AI Service Unavailable: ' . $response->status()];

        } catch (\Exception $e) {
            Log::error('OpenRouter Exception: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    protected function chatRequest($prompt)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer' => $this->siteUrl,
                'X-Title' => $this->siteName,
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
