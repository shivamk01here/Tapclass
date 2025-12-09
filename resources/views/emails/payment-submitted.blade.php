<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; background: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; border-top: 5px solid #FFBD59; }
        h1 { color: #333; }
        p { color: #555; line-height: 1.6; }
        .details { background: #f0f0f0; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .btn { display: inline-block; background: #000; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Submitted!</h1>
        <p>Hi {{ $paymentRequest->user->name }},</p>
        <p>We have received your payment proof for the <strong>{{ ucfirst($paymentRequest->plan) }}</strong> plan.</p>
        
        <div class="details">
            <p><strong>UTR/Ref:</strong> {{ $paymentRequest->utr }}</p>
            <p><strong>Amount:</strong> ₹{{ $paymentRequest->amount }}</p>
            <p><strong>Date:</strong> {{ $paymentRequest->created_at->format('d M Y, h:i A') }}</p>
        </div>

        <p>Our team is verifying the details. This usually takes about <strong>30 minutes</strong>. Once verified, your credits will be added automatically, and you will be notified.</p>
        
        <p>If you have any urgent queries, reply to this email.</p>
        
        <p>Thanks,<br>Home Tutor Consultancy</p>
    </div>
</body>
</html>
