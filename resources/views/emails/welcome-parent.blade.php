<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to HTC</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
        .header { background: linear-gradient(135deg, #10B981 0%, #059669 100%); padding: 40px 30px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 28px; font-weight: 800; margin-bottom: 8px; }
        .header p { color: rgba(255,255,255,0.9); font-size: 16px; }
        .emoji-icon { font-size: 48px; margin-bottom: 16px; }
        .content { padding: 40px 30px; }
        .greeting { font-size: 22px; color: #1a1a1a; margin-bottom: 20px; font-weight: 600; }
        .message { color: #555; font-size: 16px; line-height: 1.7; margin-bottom: 24px; }
        .highlight-box { background: linear-gradient(135deg, #ECFDF5 0%, #D1FAE5 100%); border-left: 4px solid #10B981; padding: 20px; border-radius: 8px; margin: 24px 0; }
        .highlight-box h3 { color: #1a1a1a; font-size: 18px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .highlight-box p { color: #555; font-size: 15px; }
        .steps { margin: 30px 0; }
        .steps h3 { color: #1a1a1a; font-size: 18px; margin-bottom: 16px; }
        .step { display: flex; align-items: flex-start; margin-bottom: 16px; padding: 16px; background: #fafafa; border-radius: 8px; }
        .step-number { background: #10B981; color: #ffffff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; margin-right: 14px; flex-shrink: 0; }
        .step-content h4 { color: #1a1a1a; font-size: 15px; margin-bottom: 4px; }
        .step-content p { color: #777; font-size: 14px; }
        .cta-button { display: inline-block; background: #10B981; color: #ffffff !important; text-decoration: none; padding: 16px 40px; border-radius: 8px; font-weight: 600; font-size: 16px; margin: 20px 0; }
        .cta-button:hover { background: #059669; }
        .feature-grid { display: flex; flex-wrap: wrap; gap: 12px; margin: 24px 0; }
        .feature { flex: 1 1 45%; background: #fafafa; padding: 16px; border-radius: 8px; text-align: center; min-width: 140px; }
        .feature-icon { font-size: 28px; margin-bottom: 8px; }
        .feature h4 { color: #1a1a1a; font-size: 14px; margin-bottom: 4px; }
        .feature p { color: #777; font-size: 12px; }
        .footer { background: #1a1a1a; padding: 30px; text-align: center; }
        .footer p { color: #aaa; font-size: 13px; line-height: 1.6; }
        .footer a { color: #6EE7B7; text-decoration: none; }
        .social-links { margin: 16px 0; }
        .social-links a { display: inline-block; margin: 0 8px; color: #6EE7B7; text-decoration: none; font-size: 14px; }
        @media (max-width: 600px) {
            .header { padding: 30px 20px; }
            .header h1 { font-size: 24px; }
            .content { padding: 30px 20px; }
            .greeting { font-size: 20px; }
            .step { flex-direction: column; }
            .step-number { margin-bottom: 10px; }
            .feature { flex: 1 1 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="emoji-icon">👨‍👩‍👧</div>
            <h1>Welcome to HTC!</h1>
            <p>Empowering Your Child's Education</p>
        </div>
        
        <div class="content">
            <p class="greeting">Hi {{ $user->name }}! 👋</p>
            
            <p class="message">
                Welcome to HTC! As a parent, you now have access to a powerful platform that helps you 
                manage and monitor your child's educational journey. We're here to help you find the 
                best tutors and track your child's progress every step of the way.
            </p>
            
            <div class="highlight-box">
                <h3>🌟 What You Can Do</h3>
                <p>Add your children, find the perfect tutors, manage bookings, and track their learning progress - all from one dashboard!</p>
            </div>
            
            <div class="feature-grid">
                <div class="feature">
                    <div class="feature-icon">👶</div>
                    <h4>Add Learners</h4>
                    <p>Add your children's profiles</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">🔍</div>
                    <h4>Find Tutors</h4>
                    <p>Browse verified experts</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">📅</div>
                    <h4>Book Sessions</h4>
                    <p>Schedule at your convenience</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">📊</div>
                    <h4>Track Progress</h4>
                    <p>Monitor learning outcomes</p>
                </div>
            </div>
            
            <div class="steps">
                <h3>Get started today:</h3>
                
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Add Your Child</h4>
                        <p>Create profiles for each of your learners with their grade and subjects</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>Find the Right Tutor</h4>
                        <p>Browse our verified tutors and check their ratings and reviews</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Book & Monitor</h4>
                        <p>Schedule sessions and keep track of your child's progress</p>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/parent/dashboard') }}" class="cta-button">Go to Dashboard →</a>
            </div>
        </div>
        
        <div class="footer">
            <p>Questions? We're here to help! Reply to this email anytime.</p>
            <div class="social-links">
                <a href="#">Instagram</a> • <a href="#">Twitter</a> • <a href="#">LinkedIn</a>
            </div>
            <p style="margin-top: 16px;">© {{ date('Y') }} HTC. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
