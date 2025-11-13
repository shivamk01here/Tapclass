<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password - HTC</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script>tailwind.config={theme:{extend:{colors:{primary:'#006cab'},fontFamily:{display:['Manrope','sans-serif']}}}}</script>
</head>
<body class="bg-[#f6f7f8] font-display">
  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white border rounded-xl shadow p-6">
      <h1 class="text-xl font-bold mb-2">Reset your password</h1>
      <p class="text-sm text-gray-600 mb-4">Enter your email and we'll send a 6-digit code to reset your password.</p>

      @if($errors->any())
        <div class="p-3 bg-red-50 border border-red-200 text-sm text-red-700 rounded mb-3">
          @foreach($errors->all() as $e)
            <div>{{ $e }}</div>
          @endforeach
        </div>
      @endif
      @if(session('mail_error'))
        <script>console.error('Reset OTP email failed:', @json(session('mail_error')));</script>
      @endif

      <form action="{{ route('password.forgot.send') }}" method="POST" class="space-y-3">
        @csrf
        <label class="block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2" placeholder="you@example.com"/>
        <button type="submit" class="w-full bg-primary text-white rounded py-2 font-semibold">Send code</button>
      </form>

      <div class="mt-4 text-xs text-gray-600">
        <a href="{{ route('login') }}" class="text-primary font-semibold">Back to login</a>
      </div>
    </div>
  </div>
</body>
</html>
