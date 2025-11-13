<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Verify your email - HTC (Tutor)</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script>
    tailwind.config = { theme: { extend: { colors: { primary: '#006cab', secondary: '#FFA500' }, fontFamily: { display: ['Manrope','sans-serif'] } } } }
  </script>
  <style>
    .otp-box { letter-spacing: 0.6em; }
    .success-check { width: 80px; height: 80px; border-radius: 9999px; background: #16a34a; display:flex; align-items:center; justify-content:center; color:white; }
    .fade-in { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
  </style>
</head>
<body class="bg-[#f6f7f8] font-display">
  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow p-6">
      @if(!$justVerified)
      <div class="space-y-4">
        <h1 class="text-xl font-bold">Verify your email</h1>
        <p class="text-sm text-gray-600">We sent a 6-digit code to <span class="font-medium">{{ $pending['email'] ?? '' }}</span>. Enter it below to continue.</p>
        <ul class="text-xs text-gray-500 list-disc ml-5">
          <li>Check your spam/junk folder if you don’t see the email.</li>
          <li>The code expires in 10 minutes.</li>
        </ul>

        @if($errors->any())
          <div class="p-3 bg-red-50 border border-red-200 text-sm text-red-700 rounded">
            @foreach($errors->all() as $e)
              <div>{{ $e }}</div>
            @endforeach
          </div>
        @endif
        @if(session('issue_submitted'))
          <div class="p-3 bg-green-50 border border-green-200 text-sm text-green-700 rounded">Thanks! We’ve recorded your issue.</div>
        @endif

        <form action="{{ route('register.tutor.verify-otp.verify') }}" method="POST" class="space-y-3">
          @csrf
          <label class="block text-sm font-medium">6-digit code</label>
          <input name="otp" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required class="otp-box w-full tracking-widest text-center text-lg border rounded px-3 py-2" placeholder="······" />
          <button type="submit" class="w-full bg-primary text-white rounded py-2 font-semibold">Verify & Create Account</button>
        </form>

        <div class="pt-2 text-xs text-gray-600">Didn’t receive the code?
          <button type="button" class="text-primary font-semibold underline" onclick="openIssueModal()">Raise a complaint</button>
        </div>
      </div>

      <!-- Issue Modal -->
      <div id="issue-modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center">
        <div class="bg-white w-full max-w-sm rounded-lg p-4 fade-in">
          <div class="flex items-center justify-between">
            <h3 class="font-semibold">Registration issue</h3>
            <button onclick="closeIssueModal()" class="p-1 rounded hover:bg-gray-100">✕</button>
          </div>
          <form method="POST" action="{{ route('register.tutor.otp-issue') }}" class="mt-3 space-y-3">
            @csrf
            <textarea name="message" rows="3" class="w-full border rounded p-2 text-sm" placeholder="Describe your issue (optional)"></textarea>
            <div class="flex gap-2 justify-end">
              <button type="button" onclick="closeIssueModal()" class="px-3 py-1.5 text-sm rounded border">Cancel</button>
              <button type="submit" class="px-3 py-1.5 text-sm rounded bg-primary text-white">Submit</button>
            </div>
          </form>
        </div>
      </div>

      @else
      <!-- Success State -->
      <div class="flex flex-col items-center text-center space-y-4">
        <div class="success-check"><span class="material-symbols-outlined">check</span></div>
        <h2 class="text-lg font-bold">Account created!</h2>
        <p class="text-sm text-gray-600">You’ll be redirected to your dashboard shortly…</p>
      </div>
      <script>
        setTimeout(function(){ window.location.href = "{{ route('tutor.dashboard') }}"; }, 1500);
      </script>
      @endif
    </div>
  </div>

  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <script>
    function openIssueModal(){ document.getElementById('issue-modal').classList.remove('hidden'); document.getElementById('issue-modal').classList.add('flex'); }
    function closeIssueModal(){ document.getElementById('issue-modal').classList.add('hidden'); document.getElementById('issue-modal').classList.remove('flex'); }
    @if(isset($pending['otp']) && config('app.debug'))
      console.log('DEV OTP:', '{{ $pending['otp'] }}');
    @endif
  </script>
</body>
</html>
