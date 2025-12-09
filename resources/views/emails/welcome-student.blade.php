<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Home Tutor Consultancy</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif; background-color: #f8f9fa; line-height: 1.6; }
        .email-wrapper { max-width: 600px; margin: 0 auto; background: #ffffff; }
        
        /* Header */
        .header { background: #ffffff; padding: 30px 40px; border-bottom: 1px solid #e5e7eb; text-align: center; }
        .logo { max-width: 180px; height: auto; margin-bottom: 0; }
        
        /* Main Content */
        .content { padding: 40px; background: #ffffff; }
        .greeting { font-size: 24px; color: #111827; margin-bottom: 16px; font-weight: 600; letter-spacing: -0.01em; }
        .message { color: #6b7280; font-size: 16px; line-height: 1.7; margin-bottom: 24px; }
        
        /* Welcome Box */
        .welcome-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 24px; margin: 28px 0; }
        .welcome-box h3 { color: #111827; font-size: 18px; margin-bottom: 12px; font-weight: 600; }
        .welcome-box p { color: #6b7280; font-size: 15px; line-height: 1.6; }
        .credits-highlight { color: #059669; font-weight: 600; }
        
        /* Feature Grid */
        .features { margin: 32px 0; }
        .feature-item { display: flex; align-items: flex-start; margin-bottom: 20px; padding: 20px; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; }
        .feature-icon { width: 40px; height: 40px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 16px; flex-shrink: 0; font-size: 20px; }
        .feature-content h4 { color: #111827; font-size: 16px; margin-bottom: 4px; font-weight: 600; }
        .feature-content p { color: #6b7280; font-size: 14px; line-height: 1.5; }
        
        /* CTA Button */
        .cta-section { text-align: center; margin: 32px 0; }
        .cta-button { display: inline-block; background: #111827; color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 6px; font-weight: 600; font-size: 15px; transition: all 0.2s; }
        .cta-button:hover { background: #374151; }
        
        /* Footer */
        .footer { background: #f9fafb; padding: 32px 40px; text-align: center; border-top: 1px solid #e5e7eb; }
        .footer p { color: #9ca3af; font-size: 14px; line-height: 1.6; margin-bottom: 8px; }
        .footer a { color: #6b7280; text-decoration: none; }
        .footer a:hover { color: #111827; }
        
        /* Responsive */
        @media (max-width: 600px) {
            .header, .content, .footer { padding: 24px 20px; }
            .greeting { font-size: 22px; }
            .logo { max-width: 150px; }
            .feature-item { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="header">
            <img src="https://hometutorconsultancy.com/logo.png" alt="Home Tutor Consultancy" class="logo">
        </div>
        
        <!-- Content -->
        <div class="content">
            <h1 class="greeting">Welcome to Home Tutor Consultancy, {{ $user->name }}!</h1>
            
            <p class="message">
                We're delighted to have you join our learning community. Your account has been successfully created, 
                and you're now ready to explore personalized learning experiences with verified tutors.
            </p>
            
            <div class="welcome-box">
                <h3>Your Welcome Credits</h3>
                <p>
                    To help you get started, we've added <span class="credits-highlight">200 credits</span> to your wallet 
                    and <span class="credits-highlight">1 AI Mock Test credit</span> to your account. Use these to book sessions 
                    with tutors or take AI-powered practice tests!
                </p>
            </div>
            
            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon">📚</div>
                    <div class="feature-content">
                        <h4>Find Expert Tutors</h4>
                        <p>Browse through verified tutors across all subjects and book personalized sessions</p>
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">🤖</div>
                    <div class="feature-content">
                        <h4>AI Mock Tests</h4>
                        <p>Take AI-generated practice tests tailored to your subject and difficulty level</p>
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">📊</div>
                    <div class="feature-content">
                        <h4>Track Progress</h4>
                        <p>Monitor your learning journey, view test results, and manage bookings from your dashboard</p>
                    </div>
                </div>
            </div>
            
            <div class="cta-section">
                <a href="https://hometutorconsultancy.com/student/dashboard" class="cta-button">Go to Dashboard</a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>Need assistance? Contact us at <a href="mailto:support@hometutorconsultancy.com">support@hometutorconsultancy.com</a></p>
            <p style="margin-top: 16px; color: #d1d5db; font-size: 13px;">
                © {{ date('Y') }} Home Tutor Consultancy. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>

