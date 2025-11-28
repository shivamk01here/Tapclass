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
            'count' => 'required|integer|min:5|max:25',
        ]);

        try {
            // Deduct Credit
            $user->decrement('ai_test_credits');

            // Create Record
            $test = \App\Models\AiMockTest::create([
                'user_id' => $user->id,
                'exam_context' => $request->exam,
                'subject' => $request->subject,
                'topic' => $request->topic,
                'difficulty' => $request->difficulty,
                'status' => 'pending'
            ]);

            // Call AI
            $service = new \App\Services\OpenRouterService();
            $aiResult = $service->generateTest($request->all());

            if (isset($aiResult['error']) || !isset($aiResult['questions'])) {
                $test->update(['status' => 'failed']);
                // Refund credit on failure
                $user->increment('ai_test_credits');
                return response()->json(['error' => 'AI Generation Failed: ' . ($aiResult['error'] ?? 'Invalid Format')], 500);
            }

            // Save Result
            $test->update([
                'questions_json' => json_encode($aiResult),
                'status' => 'completed'
            ]);

            return response()->json([
                'success' => true, 
                'redirect_url' => route('ai-test.show', $test->id)
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $test = \App\Models\AiMockTest::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('ai-test.show', compact('test'));
    }
}
