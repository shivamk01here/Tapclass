<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AiTestController extends Controller
{
    public function landing()
    {
        return view('ai-test.landing');
    }

    public function create()
    {
        $user = auth()->user();
        $credits = $user ? ($user->ai_test_credits ?? 0) : 0;
        $isLoggedIn = $user ? true : false;
        
        return view('ai-test.wizard', compact('credits', 'isLoggedIn'));
    }

    public function validateExam(Request $request)
    {
        $request->validate([
            'exam' => 'required|string',
        ]);

        $service = new \App\Services\OpenRouterService();
        $result = $service->validateExam($request->exam);

        if (isset($result['error'])) {
            return response()->json(['valid' => false, 'reason' => $result['error']], 500);
        }

        if ($result) {
            return response()->json($result);
        }

        return response()->json(['valid' => false, 'reason' => 'Unknown Error'], 500);
    }

    public function validateTopic(Request $request)
    {
        $request->validate([
            'exam' => 'required|string',
            'subject' => 'required|string',
            'topic' => 'required|string',
        ]);

        // Skip validation for Custom exams or Mixed mode
        if ($request->exam === 'Custom' || $request->subject === 'Mixed / Random') {
            return response()->json(['valid' => true]);
        }

        $service = new \App\Services\OpenRouterService();
        $result = $service->validateTopic($request->exam, $request->subject, $request->topic);

        if (isset($result['error'])) {
            return response()->json(['valid' => false, 'reason' => $result['error']], 500);
        }

        if ($result) {
            return response()->json($result);
        }

        return response()->json(['valid' => false, 'reason' => 'Unknown Error'], 500);
    }

    public function generate(Request $request)
    {
        $user = auth()->user();
        
        if (!$user || $user->ai_test_credits <= 0) {
            return response()->json(['error' => 'Insufficient credits'], 403);
        }

        $request->validate([
            'exam' => 'required|string',
            'subject' => 'required|string',
            'topic' => 'required|string',
            'difficulty' => 'required|string',
            'count' => 'required|integer|min:5|max:100',
            'is_full_test' => 'boolean'
        ]);

        try {
            // Deduct Credit
            $user->decrement('ai_test_credits');

            $isFullTest = $request->boolean('is_full_test');
            $count = $isFullTest ? 0 : (int)$request->count; // 0 indicates AI decides

            // Create Record
            $test = \App\Models\AiMockTest::create([
                'user_id' => $user->id,
                'exam_context' => $request->exam,
                'subject' => $request->subject,
                'topic' => $request->topic,
                'difficulty' => $request->difficulty,
                'questions_json' => json_encode([
                    'questions' => [], 
                    'total_count' => $count,
                    'is_full_test' => $isFullTest
                ]),
                'status' => 'pending'
            ]);

            // Dispatch Job
            \App\Jobs\GenerateAiTest::dispatch($test->id, $request->all());

            return response()->json([
                'success' => true, 
                'test_id' => $test->id,
                'message' => 'Test generation started.'
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }

    public function checkStatus($id)
    {
        $test = \App\Models\AiMockTest::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$test) {
            return response()->json(['status' => 'not_found'], 404);
        }

        if ($test->status === 'completed') {
            return response()->json([
                'status' => 'completed',
                'redirect_url' => route('ai-test.attempt', $test->uuid)
            ]);
        }

        // Allow start if we have enough questions (e.g., > 0) even if processing
        $data = json_decode($test->questions_json, true);
        $questionCount = isset($data['questions']) ? count($data['questions']) : 0;
        
        if ($test->status === 'processing' && $questionCount > 0) {
             return response()->json([
                'status' => 'ready_to_start', // New status for frontend
                'redirect_url' => route('ai-test.attempt', $test->uuid)
            ]);
        }

        if ($test->status === 'failed') {
            $errorData = json_decode($test->questions_json, true);
            $errorMsg = $errorData['error'] ?? 'Generation failed. Credits refunded.';
            return response()->json(['status' => 'failed', 'error' => $errorMsg]);
        }

        return response()->json(['status' => $test->status]);
    }

    public function attempt($uuid)
    {
        $test = \App\Models\AiMockTest::where('uuid', $uuid)->where('user_id', auth()->id())->firstOrFail();
        
        // If already submitted, redirect to results
        // (Assuming we'll add a 'submitted_at' or similar check later, for now just show attempt)
        
        return view('ai-test.attempt', compact('test'));
    }

    public function getQuestions($uuid)
    {
        $test = \App\Models\AiMockTest::where('uuid', $uuid)->where('user_id', auth()->id())->firstOrFail();
        $data = json_decode($test->questions_json, true);
        return response()->json([
            'questions' => $data['questions'] ?? [],
            'total_count' => $data['total_count'] ?? count($data['questions'] ?? []),
            'status' => $test->status
        ]);
    }

    public function submit(Request $request, $uuid)
    {
        $test = \App\Models\AiMockTest::where('uuid', $uuid)->where('user_id', auth()->id())->firstOrFail();
        
        $userAnswers = json_decode($request->answers, true) ?? [];
        $questionsData = json_decode($test->questions_json, true);
        $questions = $questionsData['questions'] ?? [];
        
        $score = 0;
        $total = count($questions);
        
        foreach ($questions as $index => $q) {
            if (isset($userAnswers[$index]) && $userAnswers[$index] == $q['correct_index']) {
                $score++;
            }
        }
        
        $test->update([
            'user_answers_json' => $userAnswers,
            'score' => $score,
            // 'status' => 'completed' // Already completed, but maybe add 'submitted' state if needed
        ]);
        
        return redirect()->route('ai-test.show', $test->uuid);
    }

    public function show($uuid)
    {
        $test = \App\Models\AiMockTest::where('uuid', $uuid)->where('user_id', auth()->id())->firstOrFail();
        return view('ai-test.show', compact('test'));
    }

    public function pricing()
    {
        return view('ai-test.pricing');
    }

    public function purchase(Request $request)
    {
        $request->validate([
            'plan' => 'required|string|in:standard,pro'
        ]);

        $user = auth()->user();
        
        if ($request->plan === 'standard') {
            $user->increment('ai_test_credits', 10);
            $user->update(['is_premium' => true]);
        } elseif ($request->plan === 'pro') {
            $user->increment('ai_test_credits', 100);
            $user->update(['is_premium' => true]);
        }

        return response()->json(['success' => true]);
    }
}
