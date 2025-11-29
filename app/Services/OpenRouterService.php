<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class OpenRouterService
{
    protected $baseUrl = 'https://openrouter.ai/api/v1';
    protected $apiKey;
    protected $siteUrl;
    protected $siteName;

    public function __construct()
    {
        $this->apiKey = env('OPENROUTER_API_KEY');
        $this->siteUrl = Config::get('app.url');
        $this->siteName = Config::get('app.name');
    }

    public function validateTopic($exam, $subject, $topic)
    {
        $model = "google/gemini-2.0-flash-001";

        $prompt = "You are an expert academic counselor. A student wants to take a mock test for the exam '$exam'.
        They have entered the Subject: '$subject' and Topic: '$topic'.
        
        Task:
        1. Verify if this subject and topic are valid and relevant for the '$exam'.
        2. If valid, standardize the names (e.g., 'phy' -> 'Physics', 'thermo' -> 'Thermodynamics').
        3. If invalid, explain why briefly.
        
        Return ONLY a raw JSON object (no markdown, no code blocks):
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
                
                // Strip Markdown
                $content = preg_replace('/^```json\s*|\s*```$/', '', trim($content));
                $content = str_replace(['```json', '```'], '', $content);
                
                // Extract JSON if wrapped in text
                if (preg_match('/\{.*\}/s', $content, $matches)) {
                    $content = $matches[0];
                }
                
                $json = json_decode($content, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('OpenRouter JSON Parse Error (Validate): ' . $content);
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

    public function generateTest($config, $model = "google/gemini-2.0-flash-001")
    {
        $count = $config['count'] ?? 5;
        $examContext = $config['exam'] === 'Custom' ? "a generic academic exam" : $config['exam'];
        $subjectContext = $config['subject'] === 'Mixed / Random' ? "General Knowledge and Aptitude relevant to " . $examContext : $config['subject'];
        $topicContext = $config['topic'] === 'General Knowledge' ? "various fundamental topics" : $config['topic'];

        $prompt = "Act as a senior exam setter for {$examContext}. Create a mock test batch.
        Constraints:
        - Subject: {$subjectContext}
        - Topic Focus: {$topicContext}
        - Count: Generate EXACTLY {$count} questions.
        - Difficulty: {$config['difficulty']}
        
        Format: Return strictly valid JSON (no markdown, no code blocks) with this structure:
        {
            \"questions\": [
                {
                    \"question\": \"Question text\",
                    \"options\": [\"A\", \"B\", \"C\", \"D\"],
                    \"correct_index\": 0,
                    \"explanation\": \"Detailed explanation\"
                }
            ]
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
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? '';
                
                // Strip Markdown
                $content = preg_replace('/^```json\s*|\s*```$/', '', trim($content));
                $content = str_replace(['```json', '```'], '', $content);

                // Extract JSON if wrapped in text
                if (preg_match('/\{.*\}/s', $content, $matches)) {
                    $content = $matches[0];
                }

                $json = json_decode($content, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error("OpenRouter JSON Parse Error ($model): " . $content);
                    return ['error' => 'Failed to parse AI response.'];
                }
                
                if (!isset($json['questions'])) {
                     Log::error("OpenRouter Invalid Structure ($model): " . $content);
                     return ['error' => 'Invalid JSON structure.'];
                }

                return $json;
            }

            Log::error("OpenRouter API Error ($model): " . $response->body());
            return ['error' => 'AI Service Unavailable: ' . $response->status()];

        } catch (\Exception $e) {
            Log::error("OpenRouter Exception ($model): " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    public function determineExamSize($exam, $subject)
    {
        $model = "google/gemini-2.0-flash-001";
        $prompt = "You are an exam expert. A student wants a 'Full Mock Test' for the exam: '$exam' (Subject: '$subject').
        
        Task: Determine the standard number of questions for a full section/paper of this exam.
        Rules:
        1. If it's a known exam (e.g., JEE Mains Physics), return the standard count (e.g., 25 or 30).
        2. If it's a generic or custom exam, suggest a reasonable comprehensive number (e.g., 50).
        3. Max limit is 100. If the real exam has more (e.g., NEET 180), cap it at 100.
        4. Return ONLY an integer. No text.";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'HTTP-Referer' => $this->siteUrl,
                'X-Title' => $this->siteName,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'temperature' => 0.3,
            ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'] ?? '50';
                $count = (int) preg_replace('/[^0-9]/', '', $content);
                return $count > 0 ? min($count, 100) : 50;
            }
            return 50; // Default fallback
        } catch (\Exception $e) {
            Log::error('DetermineExamSize Exception: ' . $e->getMessage());
            return 50;
        }
    }

    public function generateTestWithFallback($config)
    {
        $models = [
            'google/gemini-2.0-flash-001',
            'google/gemini-flash-1.5',
            'meta-llama/llama-3.2-3b-instruct:free'
        ];

        foreach ($models as $model) {
            Log::info("Attempting generation with model: $model");
            $result = $this->generateTest($config, $model);
            
            if (!isset($result['error'])) {
                Log::info("Success with model: $model");
                return $result;
            }
            
            Log::warning("Failed with model: $model. Reason: " . $result['error']);
        }

        return ['error' => 'All models failed to generate the test.'];
    }

    public function validateExam($examName)
    {
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
}
