<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Mock Test Results</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif; background-color: #f8f9fa; line-height: 1.6; }
        .email-wrapper { max-width: 600px; margin: 0 auto; background: #ffffff; }
        
        /* Header */
        .header { background: #ffffff; padding: 24px 40px; border-bottom: 1px solid #e5e7eb; text-align: center; }
        .brand { font-size: 32px; font-weight: 900; letter-spacing: -0.5px; color: #111827; }
        
        /* Content */
        .content { padding: 40px; background: #ffffff; }
        .greeting { font-size: 24px; color: #111827; margin-bottom: 12px; font-weight: 600; }
        .subtitle { color: #6b7280; font-size: 16px; line-height: 1.6; margin-bottom: 32px; }
        
        /* Score Box */
        .score-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 32px 24px; text-align: center; margin-bottom: 32px; }
        .grade { font-size: 56px; font-weight: 900; color: #111827; line-height: 1; margin-bottom: 8px; }
        .grade-message { font-size: 18px; color: #6b7280; font-weight: 500; margin-bottom: 24px; }
        
        /* Stats Grid */
        .stats-grid { display: flex; justify-content: space-around; margin-top: 24px; }
        .stat-item { text-align: center; }
        .stat-value { font-size: 28px; font-weight: 700; display: block; margin-bottom: 4px; }
        .stat-label { font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; }
        .c-green { color: #059669; }
        .c-red { color: #dc2626; }
        .c-gray { color: #6b7280; }
        
        /* Cards */
        .card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 24px; margin-bottom: 20px; }
        .card-title { font-size: 14px; font-weight: 700; color: #111827; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid #e5e7eb; }
        
        /* Lists */
        .recommendations { margin: 0; padding: 0; list-style: none; }
        .recommendations li { margin-bottom: 12px; color: #4b5563; font-size: 15px; padding-left: 24px; position: relative; line-height: 1.6; }
        .recommendations li:before { content: "•"; position: absolute; left: 8px; color: #111827; font-weight: bold; font-size: 18px; }
        
        /* Button */
        .cta-section { text-align: center; margin: 32px 0; }
        .cta-button { display: inline-block; background: #111827; color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 6px; font-weight: 600; font-size: 15px; }
        .cta-button:hover { background: #374151; }
        
        /* Footer */
        .footer { background: #f9fafb; padding: 24px 40px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { color: #9ca3af; font-size: 13px; }
        
        /* Responsive */
        @media (max-width: 600px) {
            .header, .content, .footer { padding: 24px 20px; }
            .grade { font-size: 48px; }
            .stats-grid { flex-wrap: wrap; gap: 16px; }
            .stat-item { flex: 1 0 30%; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <div class="brand">HTC</div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <h1 class="greeting">Hi {{ $user->name }},</h1>
            <p class="subtitle">You've completed <strong>{{ $test->subject }} - {{ $test->topic }}</strong>. Here's your performance summary.</p>
            
            <!-- Score Box -->
            <div class="score-box">
                <div class="grade">{{ $stats['grade'] }}</div>
                <div class="grade-message">{{ $stats['percentage'] }}% - {{ $stats['gradeMessage'] }}</div>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-value c-green">{{ $stats['correct'] }}</span>
                        <span class="stat-label">Correct</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value c-red">{{ $stats['wrong'] }}</span>
                        <span class="stat-label">Wrong</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value c-gray">{{ $stats['skipped'] }}</span>
                        <span class="stat-label">Skipped</span>
                    </div>
                </div>
            </div>
            
            <!-- Strengths -->
            @if($stats['percentage'] >= 50)
            <div class="card">
                <div class="card-title">Strengths</div>
                <p style="color: #4b5563; font-size: 15px; line-height: 1.6;">
                    You showed good understanding of <strong>{{ $test->topic }}</strong>. Keep building on this momentum!
                </p>
            </div>
            @else
            <div class="card">
                <div class="card-title">Strengths</div>
                <p style="color: #6b7280; font-size: 15px; line-height: 1.6;">
                    Focus on improving your fundamentals to build strengths in this area.
                </p>
            </div>
            @endif
            
            <!-- Areas to Improve -->
            <div class="card">
                <div class="card-title">Areas to Improve</div>
                <ul class="recommendations">
                    @if($stats['wrong'] > 0)
                    <li>Review the {{ $stats['wrong'] }} incorrect answer{{ $stats['wrong'] > 1 ? 's' : '' }} below</li>
                    @endif
                    @if($stats['skipped'] > 0)
                    <li>Attempt all questions - {{ $stats['skipped'] }} {{ $stats['skipped'] > 1 ? 'were' : 'was' }} skipped</li>
                    @endif
                    <li>Practice more {{ $test->difficulty }} / {{ $test->topic }} problems</li>
                    <li>Read explanations carefully for each question</li>
                </ul>
            </div>
            
            <!-- Personalized Suggestions -->
            <div class="card">
                <div class="card-title">Personalized Suggestions</div>
                <ul class="recommendations">
                    @if($stats['percentage'] < 50)
                        <li>Start with basic concepts of {{ $test->subject }} before attempting advanced questions</li>
                        <li>Consider studying with video tutorials or detailed notes</li>
                        <li>Take smaller quizzes (10-15 questions) to build confidence</li>
                    @elseif($stats['percentage'] < 80)
                        <li>Analyze your wrong answers to identify patterns and avoid repeating mistakes</li>
                        <li>Practice timed quizzes to improve both speed and accuracy</li>
                        <li>Focus on the specific areas where you lost marks</li>
                    @else
                        <li>Excellent work! Challenge yourself with higher difficulty levels</li>
                        <li>Aim for consistency - try to maintain this performance</li>
                        <li>Consider helping others to reinforce your understanding</li>
                    @endif
                </ul>
            </div>
            
            <div class="cta-section">
                <a href="https://hometutorconsultancy.com/ai-mock-tests/view/{{ $test->uuid }}" class="cta-button">View Full Analysis</a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>© {{ date('Y') }} Home Tutor Consultancy. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
