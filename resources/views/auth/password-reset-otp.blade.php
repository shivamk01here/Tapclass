<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Enter Code - Reset Password</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script>tailwind.config={theme:{extend:{colors:{primary:'#006cab'},fontFamily:{display:['Manrope','sans-serif']}}}}</script>
</head>
<body class="bg-[#f6f7f8] font-display">
  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white border rounded-xl shadow p-6">
      <h1 class="text-xl font-bold mb-2">Enter the 6-digit code</h1>
      <p class="text-sm text-gray-600 mb-4">We sent a code to <span class="font-medium">{{ $email }}</span>. Enter it below with your new password.</p>

      @if($errors->any())
        <div class="p-3 bg-red-50 border border-red-200 text-sm text-red-700 rounded mb-3">
          @foreach($errors->all() as $e)
            <div>{{ $e }}</div>
          @endforeach
        </div>
      @endif

      <form action="{{ route('password.reset-otp.submit') }}" method="POST" class="space-y-3">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}"/>
        <label class="block text-sm font-medium">6-digit code</label>
        <input name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required class="w-full border rounded px-3 py-2 text-center tracking-widest" placeholder="······" />
        <label class="block text-sm font-medium">New password</label>
        <input type="password" name="password" required class="w-full border rounded px-3 py-2" placeholder="Minimum 8 characters" />
        <label class="block text-sm font-medium">Confirm password</label>
        <input type="password" name="password_confirmation" required class="w-full border rounded px-3 py-2" />
        <button type="submit" class="w-full bg-primary text-white rounded py-2 font-semibold">Reset password</button>
      </form>

      <div class="mt-4 text-xs text-gray-600">
        <a href="{{ route('password.forgot') }}" class="text-primary font-semibold">Back</a>
      </div>
    </div>
  </div>

  @if(session('debug_otp') && config('app.debug'))
    <script>console.log('DEV Reset OTP:', '{{ session('debug_otp') }}');</script>
  @endif
</body>
</html>
