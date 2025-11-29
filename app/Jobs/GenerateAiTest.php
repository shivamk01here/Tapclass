<?php

namespace App\Jobs;

use App\Models\AiMockTest;
use App\Services\OpenRouterService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateAiTest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $testId;
    protected $config;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($testId, $config)
    {
        $this->testId = $testId;
        $this->config = $config;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $test = AiMockTest::find($this->testId);

        if (!$test) {
            Log::error("GenerateAiTest Job: Test ID {$this->testId} not found.");
            return;
        }

        try {
            $test->update(['status' => 'processing']);
            Log::info("Job {$this->testId}: Started Processing.");

            $service = new OpenRouterService();
            
            // Determine count for Full Test if needed
            if (!empty($this->config['is_full_test']) || ($this->config['count'] ?? 0) == 0) {
                Log::info("Job {$this->testId}: Determining Full Test size...");
                $determinedCount = $service->determineExamSize($this->config['exam'], $this->config['subject']);
                $this->config['count'] = $determinedCount;
                
                // Update test record with determined count so frontend shows correct placeholders
                $currentJson = json_decode($test->questions_json, true);
                $currentJson['total_count'] = $determinedCount;
                $test->update(['questions_json' => json_encode($currentJson)]);
                
                Log::info("Job {$this->testId}: Full Test size set to {$determinedCount}");
            }

            $totalQuestions = $this->config['count'];
            $batchSize = 5;
            $batches = ceil($totalQuestions / $batchSize);
            
            $allQuestions = [];

            for ($i = 0; $i < $batches; $i++) {
                $currentBatchSize = min($batchSize, $totalQuestions - count($allQuestions));
                
                Log::info("Job {$this->testId}: Starting Batch " . ($i + 1) . "/{$batches} (Size: {$currentBatchSize})");

                // Update config for this batch
                $this->config['count'] = $currentBatchSize;

                // Call AI Service with Fallback
                $aiResult = $service->generateTestWithFallback($this->config);

                if (isset($aiResult['error'])) {
                    Log::error("Job {$this->testId}: Batch " . ($i + 1) . " Failed. Error: " . $aiResult['error']);
                    // Skip this batch, try to continue
                    continue; 
                }

                if (empty($aiResult['questions'])) {
                     Log::warning("Job {$this->testId}: Batch " . ($i + 1) . " returned no questions.");
                     continue;
                }

                // Merge questions
                $allQuestions = array_merge($allQuestions, $aiResult['questions']);
                
                // Save progress immediately so user can start
                $test->update([
                    'questions_json' => json_encode(['questions' => $allQuestions]),
                ]);
                
                Log::info("Job {$this->testId}: Batch " . ($i + 1) . " Saved. Total Questions: " . count($allQuestions));
            }

            if (empty($allQuestions)) {
                throw new \Exception('No questions were generated after all batches.');
            }

            $test->update([
                'status' => 'completed',
                'questions_json' => json_encode(['questions' => $allQuestions]),
            ]);
            
            Log::info("Job {$this->testId}: Completed Successfully.");

        } catch (\Exception $e) {
            Log::error("Job {$this->testId}: Failed. Exception: " . $e->getMessage());
            
            // Refund credit
            $user = \App\Models\User::find($test->user_id);
            if ($user) {
                $user->increment('ai_test_credits');
            }

            $test->update([
                'status' => 'failed',
                'questions_json' => json_encode(['error' => $e->getMessage()])
            ]);
        }
    }
}
