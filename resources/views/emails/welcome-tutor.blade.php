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
        .header { background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%); padding: 40px 30px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 28px; font-weight: 800; margin-bottom: 8px; }
        .header p { color: rgba(255,255,255,0.9); font-size: 16px; }
        .emoji-icon { font-size: 48px; margin-bottom: 16px; }
        .content { padding: 40px 30px; }
        .greeting { font-size: 22px; color: #1a1a1a; margin-bottom: 20px; font-weight: 600; }
        .message { color: #555; font-size: 16px; line-height: 1.7; margin-bottom: 24px; }
        .highlight-box { background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%); border-left: 4px solid #4F46E5; padding: 20px; border-radius: 8px; margin: 24px 0; }
        .highlight-box h3 { color: #1a1a1a; font-size: 18px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .highlight-box p { color: #555; font-size: 15px; }
        .status-badge { display: inline-block; background: #FEF3C7; color: #92400E; font-weight: 600; padding: 4px 12px; border-radius: 20px; font-size: 14px; }
        .steps { margin: 30px 0; }
        .steps h3 { color: #1a1a1a; font-size: 18px; margin-bottom: 16px; }
        .step { display: flex; align-items: flex-start; margin-bottom: 16px; padding: 16px; background: #fafafa; border-radius: 8px; }
        .step-number { background: #4F46E5; color: #ffffff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; margin-right: 14px; flex-shrink: 0; }
        .step-content h4 { color: #1a1a1a; font-size: 15px; margin-bottom: 4px; }
        .step-content p { color: #777; font-size: 14px; }
        .cta-button { display: inline-block; background: #4F46E5; color: #ffffff !important; text-decoration: none; padding: 16px 40px; border-radius: 8px; font-weight: 600; font-size: 16px; margin: 20px 0; }
        .cta-button:hover { background: #4338CA; }
        .info-box { background: #FEF3C7; border-radius: 8px; padding: 16px; margin: 24px 0; }
        .info-box p { color: #92400E; font-size: 14px; display: flex; align-items: flex-start; gap: 8px; }
        .footer { background: #1a1a1a; padding: 30px; text-align: center; }
        .footer p { color: #aaa; font-size: 13px; line-height: 1.6; }
        .footer a { color: #A78BFA; text-decoration: none; }
        .social-links { margin: 16px 0; }
        .social-links a { display: inline-block; margin: 0 8px; color: #A78BFA; text-decoration: none; font-size: 14px; }
        @media (max-width: 600px) {
            .header { padding: 30px 20px; }
            .header h1 { font-size: 24px; }
            .content { padding: 30px 20px; }
            .greeting { font-size: 20px; }
            .step { flex-direction: column; }
            .step-number { margin-bottom: 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="emoji-icon">👨‍🏫</div>
            <h1>Welcome to HTC!</h1>
            <p>Start Your Teaching Journey Today</p>
        </div>
        
        <div class="content">
            <p class="greeting">Hi {{ $user->name }}! 👋</p>
            
            <p class="message">
                Welcome to the HTC tutor community! We're excited to have you join our platform where 
                passionate educators connect with eager learners. Your expertise can make a real difference 
                in students' lives.
            </p>
            
            <div class="highlight-box">
                <h3>📋 Account Status</h3>
                <p>Your account is currently <span class="status-badge">⏳ Pending Verification</span></p>
                <p style="margin-top: 8px;">Complete your profile to get verified and start accepting bookings!</p>
            </div>
            
            <div class="steps">
                <h3>Get started in 3 easy steps:</h3>
                
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Complete Your Profile</h4>
                        <p>Add your qualifications, experience, and teaching subjects</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>Set Your Availability</h4>
                        <p>Define your teaching schedule and hourly rates</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Get Verified</h4>
                        <p>Upload documents for verification and start receiving bookings</p>
                    </div>
                </div>
            </div>
            
            <div class="info-box">
                <p>💡 <strong>Pro Tip:</strong> Tutors with complete profiles and verified credentials get 3x more bookings!</p>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/tutor/dashboard') }}" class="cta-button">Complete Your Profile →</a>
            </div>
        </div>
        
        <div class="footer">
            <p>Questions about the verification process? Reply to this email!</p>
            <div class="social-links">
                <a href="#">Instagram</a> • <a href="#">Twitter</a> • <a href="#">LinkedIn</a>
            </div>
            <p style="margin-top: 16px;">© {{ date('Y') }} HTC. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
