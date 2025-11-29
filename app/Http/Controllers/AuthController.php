<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentProfile;
use App\Models\TutorProfile;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check for explicit redirect parameter (e.g. from AI test flow)
            if ($request->has('redirect') && $request->filled('redirect')) {
                return redirect($request->input('redirect'));
            }

            // Redirect based on role
            if ($user->isStudent()) {
                return redirect()->route('student.dashboard');
            } elseif ($user->isTutor()) {
                return redirect()->route('tutor.dashboard');
            } elseif ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isParent()) {
                return redirect()->route('parent.dashboard');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function showStudentRegister()
    {
        $subjects = \App\Models\Subject::where('is_active', true)->orderBy('name')->get();
        return view('auth.register-student', compact('subjects'));
    }

    public function registerStudent(Request $request)
    {
        $isGoogleAuth = $request->has('google_auth') && session('google_user_data');
        
        $rules = [
            'first_name' => $isGoogleAuth ? 'nullable' : 'required|string|max:100',
            'last_name'  => $isGoogleAuth ? 'nullable' : 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'class_slab' => 'required|in:1-5,6-8,9-12,undergrad,postgrad',
        ];
        
        if (!$isGoogleAuth) {
            $rules['password'] = 'required|min:6|confirmed';
        }
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // If Google OAuth, proceed with immediate creation (as before)
        if ($isGoogleAuth) {
            DB::beginTransaction();
            try {
                $googleData = session('google_user_data');
                $userData = [
                    'name' => $googleData['name'] ?? '',
                    'email' => $googleData['email'],
                    'role' => 'student',
                    'email_verified_at' => now(),
                    'google_id' => $googleData['google_id'] ?? null,
                    'password' => Hash::make(Str::random(32)),
                ];
                $user = User::create($userData);
                StudentProfile::create([
                    'user_id' => $user->id,
                    'grade' => $request->class_slab,
                    'location' => null,
                    'pin_code' => null,
                    'latitude' => null,
                    'longitude' => null,
                    'subjects_of_interest' => [],
                ]);
                Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 10000.00,
                    'total_credited' => 10000.00,
                    'total_debited' => 0.00,
                ]);

                DB::commit();
                session()->forget(['google_user_data', 'oauth_role']);
                Auth::login($user);
                return redirect()->route('student.dashboard')->with('success', 'Registration successful! Welcome to Htc.');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
            }
        }

        // Non-Google flow: generate OTP, store in session, send email, redirect to OTP page
        $fullName = trim(($request->first_name ?? '') . ' ' . ($request->last_name ?? ''));
        $otp = random_int(100000, 999999);
        $pending = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $fullName,
            'email' => $request->email,
            'class_slab' => $request->class_slab,
            'password_hash' => Hash::make($request->password),
            'otp' => (string)$otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)->toIso8601String(),
            'attempts' => 0,
            'created_at' => Carbon::now()->toIso8601String(),
        ];
        session(['pending_student_registration' => $pending]);

        // Send a short email with the OTP
        try {
            // Force SMTP mailer
            Mail::mailer('smtp')->raw(
                "Hi $fullName,\n\nYour HTC verification code is $otp. It expires in 10 minutes.\nIf you didn’t request this, you can ignore this email.\n\n— Team HTC",
                function ($message) use ($request) {
                    $message->to($request->email)
                            ->subject('Your HTC verification code');
                }
            );
            // Log OTP to server console/log for now
            Log::info('DEV: Sent student OTP', ['email' => $request->email, 'otp' => $otp]);
        } catch (\Throwable $e) {
            Log::error('Failed to send OTP email', ['error' => $e->getMessage()]);
            // Keep the session; let user try again and surface error to browser console
            return back()->withErrors(['email' => 'Failed to send OTP email. Please try again.'])->with('mail_error', $e->getMessage())->withInput();
        }

        return redirect()->route('register.student.verify-otp.show');
    }

    public function showTutorRegister()
    {
        $subjects = \App\Models\Subject::where('is_active', true)->get();
        return view('auth.register-tutor', compact('subjects'));
    }

    public function showParentRegister()
    {
        return view('auth.register-parent');
    }

    public function registerTutor(Request $request)
    {
        $isGoogleAuth = $request->has('google_auth') && session('google_user_data');
        
        $rules = [
            'name' => $isGoogleAuth ? 'nullable' : 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ];
        
        if (!$isGoogleAuth) {
            $rules['password'] = 'required|min:6|confirmed';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        if ($isGoogleAuth) {
            DB::beginTransaction();
            try {
                $googleData = session('google_user_data');
                $user = User::create([
                    'name' => $googleData['name'] ?? '',
                    'email' => $googleData['email'],
                    'role' => 'tutor',
                    'email_verified_at' => now(),
                    'google_id' => $googleData['google_id'] ?? null,
                    'password' => Hash::make(Str::random(32)),
                ]);
                TutorProfile::create([
                    'user_id' => $user->id,
                    'verification_status' => 'pending',
                    'onboarding_completed' => false,
                    'onboarding_step' => 0,
                ]);
                DB::commit();
                session()->forget(['google_user_data', 'oauth_role']);
                Auth::login($user);
                return redirect()->route('tutor.dashboard')->with('success', 'Registration successful!');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
            }
        }

        // Non-Google flow: OTP first, no DB writes until verified
        $name = $request->name;
        $otp = random_int(100000, 999999);
        $pending = [
            'name' => $name,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'otp' => (string)$otp,
            'otp_expires_at' => Carbon::now()->addMinutes(10)->toIso8601String(),
            'attempts' => 0,
            'created_at' => Carbon::now()->toIso8601String(),
        ];
        session(['pending_tutor_registration' => $pending]);

        try {
            Mail::mailer('smtp')->raw(
                "Hi $name,\n\nYour HTC tutor verification code is $otp. It expires in 10 minutes.\nIf you didn’t request this, you can ignore this email.\n\n— Team HTC",
                function ($message) use ($request) {
                    $message->to($request->email)
                            ->subject('Your HTC verification code');
                }
            );
            Log::info('DEV: Sent tutor OTP', ['email' => $request->email, 'otp' => $otp]);
        } catch (\Throwable $e) {
            Log::error('Failed to send tutor OTP email', ['error' => $e->getMessage()]);
            return back()->withErrors(['email' => 'Failed to send OTP email. Please try again.'])->with('mail_error', $e->getMessage())->withInput();
        }

        return redirect()->route('register.tutor.verify-otp.show');
    }

    public function showTutorOtp(Request $request)
    {
        $pending = session('pending_tutor_registration');
        if (!$pending) {
            return redirect()->route('register.tutor')->withErrors(['error' => 'Please fill the registration form first.']);
        }
        return view('auth.tutor-verify-otp', ['pending' => $pending, 'justVerified' => false]);
    }

    public function verifyTutorOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);
        $pending = session('pending_tutor_registration');
        if (!$pending) {
            return redirect()->route('register.tutor')->withErrors(['error' => 'Session expired. Please start again.']);
        }
        $expiresAt = Carbon::parse($pending['otp_expires_at'] ?? Carbon::now()->subMinute());
        if (Carbon::now()->greaterThan($expiresAt)) {
            return back()->withErrors(['otp' => 'OTP expired. Please restart registration.']);
        }
        if ($request->otp !== ($pending['otp'] ?? '')) {
            $pending['attempts'] = ($pending['attempts'] ?? 0) + 1;
            session(['pending_tutor_registration' => $pending]);
            return back()->withErrors(['otp' => 'Invalid code. Please try again.']);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $pending['name'],
                'email' => $pending['email'],
                'role' => 'tutor',
                'password' => $pending['password_hash'],
                'email_verified_at' => now(),
            ]);
            TutorProfile::create([
                'user_id' => $user->id,
                'verification_status' => 'pending',
                'onboarding_completed' => false,
                'onboarding_step' => 0,
            ]);
            DB::commit();
            session()->forget(['pending_tutor_registration']);
            Auth::login($user);
            return view('auth.tutor-verify-otp', ['pending' => null, 'justVerified' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Could not create your account. Please try again.']);
        }
    }

    public function submitTutorOtpIssue(Request $request)
    {
        $pending = session('pending_tutor_registration');
        $message = (string)($request->input('message'));
        try {
            \App\Models\RegistrationIssue::create([
                'name' => $pending['name'] ?? 'Unknown',
                'email' => $pending['email'] ?? ($request->input('email') ?? 'unknown@example.com'),
                'role' => 'tutor',
                'message' => $message,
                'payload' => $pending ? collect($pending)->except(['otp','password_hash'])->toArray() : [],
                'status' => 'open',
            ]);
        } catch (\Throwable $e) {}
        return back()->with('issue_submitted', true);
    }

    public function registerParent(Request $request)
    {
        $isGoogleAuth = $request->has('google_auth') && session('google_user_data');
        $rules = [
            'name' => $isGoogleAuth ? 'nullable' : 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ];
        if (! $isGoogleAuth) {
            $rules['password'] = 'required|min:6|confirmed';
        }
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($isGoogleAuth) {
            \DB::beginTransaction();
            try {
                $googleData = session('google_user_data');
                $userData = [
                    'name' => $googleData['name'] ?? '',
                    'email' => $googleData['email'],
                    'role' => 'parent',
                    'email_verified_at' => now(),
                    'google_id' => $googleData['google_id'] ?? null,
                    'password' => \Hash::make(\Str::random(32)),
                ];
                $user = User::create($userData);
                Wallet::create([
                    'user_id' => $user->id,
                    'balance' => 0,
                    'total_credited' => 0,
                    'total_debited' => 0,
                ]);
                \DB::commit();
                session()->forget(['google_user_data','oauth_role']);
                \Auth::login($user);
                return redirect()->route('onboarding.parent.show')->with('success','Welcome! Add your first learner.');
            } catch (\Exception $e) {
                \DB::rollBack();
                return back()->withErrors(['error' => 'Registration failed: '.$e->getMessage()])->withInput();
            }
        }

        // Non-Google: OTP first, no DB persistence yet
        $name = $request->name;
        $otp = random_int(100000, 999999);
        $pending = [
            'name' => $name,
            'email' => $request->email,
            'password_hash' => \Hash::make($request->password),
            'otp' => (string)$otp,
            'otp_expires_at' => \Carbon\Carbon::now()->addMinutes(10)->toIso8601String(),
            'attempts' => 0,
            'created_at' => \Carbon\Carbon::now()->toIso8601String(),
        ];
        session(['pending_parent_registration' => $pending]);

        try {
            \Mail::mailer('smtp')->raw(
                "Hi $name,\n\nYour HTC parent verification code is $otp. It expires in 10 minutes.\nIf you didn’t request this, you can ignore this email.\n\n— Team HTC",
                function ($message) use ($request) {
                    $message->to($request->email)
                            ->subject('Your HTC verification code');
                }
            );
            \Log::info('DEV: Sent parent OTP', ['email' => $request->email, 'otp' => $otp]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send parent OTP email', ['error' => $e->getMessage()]);
            return back()->withErrors(['email' => 'Failed to send OTP email. Please try again.'])->with('mail_error', $e->getMessage())->withInput();
        }

        return redirect()->route('register.parent.verify-otp.show');
    }

    public function showParentOtp()
    {
        $pending = session('pending_parent_registration');
        if (!$pending) {
            return redirect()->route('register.parent')->withErrors(['error' => 'Please fill the registration form first.']);
        }
        return view('auth.parent-verify-otp', ['pending' => $pending, 'justVerified' => false]);
    }

    public function verifyParentOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);
        $pending = session('pending_parent_registration');
        if (!$pending) {
            return redirect()->route('register.parent')->withErrors(['error' => 'Session expired. Please start again.']);
        }
        $expiresAt = \Carbon\Carbon::parse($pending['otp_expires_at'] ?? \Carbon\Carbon::now()->subMinute());
        if (\Carbon\Carbon::now()->greaterThan($expiresAt)) {
            return back()->withErrors(['otp' => 'OTP expired. Please restart registration.']);
        }
        if ($request->otp !== ($pending['otp'] ?? '')) {
            $pending['attempts'] = ($pending['attempts'] ?? 0) + 1;
            session(['pending_parent_registration' => $pending]);
            return back()->withErrors(['otp' => 'Invalid code. Please try again.']);
        }

        \DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $pending['name'],
                'email' => $pending['email'],
                'role' => 'parent',
                'password' => $pending['password_hash'],
                'email_verified_at' => now(),
            ]);
            Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'total_credited' => 0,
                'total_debited' => 0,
            ]);
            \DB::commit();
            session()->forget(['pending_parent_registration']);
            \Auth::login($user);
            return view('auth.parent-verify-otp', ['pending' => null, 'justVerified' => true]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withErrors(['error' => 'Could not create your account. Please try again.']);
        }
    }

    public function submitParentOtpIssue(Request $request)
    {
        $pending = session('pending_parent_registration');
        $message = (string)($request->input('message'));
        try {
            \App\Models\RegistrationIssue::create([
                'name' => $pending['name'] ?? 'Unknown',
                'email' => $pending['email'] ?? ($request->input('email') ?? 'unknown@example.com'),
                'role' => 'parent',
                'message' => $message,
                'payload' => $pending ? collect($pending)->except(['otp','password_hash'])->toArray() : [],
                'status' => 'open',
            ]);
        } catch (\Throwable $e) {}
        return back()->with('issue_submitted', true);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    // Forgot password (OTP-based)
    public function showForgot()
    {
        return view('auth.password-forgot');
    }

    public function sendForgotOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = strtolower($request->email);
        $user = \App\Models\User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We could not find an account with that email.'])->withInput();
        }
        $otp = random_int(100000, 999999);
        $hashed = \Hash::make((string)$otp);
        // Clean old tokens and insert new
        \DB::table('password_reset_tokens')->where('email', $email)->delete();
        \DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $hashed,
            'created_at' => now(),
        ]);
        try {
            \Mail::mailer('smtp')->raw(
                "Hi {$user->name},\n\nYour HTC password reset code is $otp. It expires in 15 minutes.\nIf you didn’t request this, you can ignore this email.\n\n— Team HTC",
                function ($message) use ($email) {
                    $message->to($email)->subject('Your HTC password reset code');
                }
            );
            \Log::info('DEV: Sent password reset OTP', ['email' => $email, 'otp' => $otp]);
        } catch (\Throwable $e) {
            \Log::error('Failed to send reset OTP email', ['error' => $e->getMessage()]);
            return back()->withErrors(['email' => 'Failed to send reset email. Please try again.'])->with('mail_error', $e->getMessage())->withInput();
        }
        // show on console in next page
        return redirect()->route('password.reset-otp.show', ['email' => $email])->with('debug_otp', $otp);
    }

    public function showResetOtp(Request $request)
    {
        $email = (string)$request->query('email');
        if ($email === '') { return redirect()->route('password.forgot'); }
        return view('auth.password-reset-otp', [ 'email' => $email ]);
    }

    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:8|confirmed',
        ]);
        $email = strtolower($request->email);
        $row = \DB::table('password_reset_tokens')->where('email', $email)->latest('created_at')->first();
        if (!$row) { return back()->withErrors(['otp' => 'No reset request found. Please request a new code.'])->withInput(); }
        // Expiry 15 minutes
        if (now()->diffInMinutes(\Carbon\Carbon::parse($row->created_at)) > 15) {
            return back()->withErrors(['otp' => 'Code expired. Please request a new code.'])->withInput();
        }
        if (!\Hash::check($request->otp, $row->token)) {
            return back()->withErrors(['otp' => 'Invalid code. Please try again.'])->withInput();
        }
        // Update password
        $user = \App\Models\User::where('email', $email)->first();
        if (!$user) { return back()->withErrors(['email' => 'Account not found.'])->withInput(); }
        $user->update(['password' => \Hash::make($request->password)]);
        // Clear tokens
        \DB::table('password_reset_tokens')->where('email', $email)->delete();
        return redirect()->route('login')->with('success','Password has been reset. Please sign in.');
    }

    // Google OAuth methods
    public function redirectToGoogle(Request $request)
    {
        // Store the intended role (student/tutor) in session
        if ($request->has('role')) {
            session(['oauth_role' => $request->role]);
        }
        
        // Store redirect URL if present
        if ($request->has('redirect') && $request->filled('redirect')) {
            session(['oauth_redirect' => $request->redirect]);
        }
        
        return Socialite::driver('google')
            ->with(['access_type' => 'offline'])
            ->scopes(['email', 'profile'])
            ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->user();
            
            // Check if user exists
            $user = User::where('email', $googleUser->email)->first();
            
            if ($user) {
                // User exists, just log them in
                Auth::login($user);
                
                // Redirect based on role
                if (session()->has('oauth_redirect')) {
                    $redirectUrl = session('oauth_redirect');
                    session()->forget('oauth_redirect');
                    return redirect($redirectUrl);
                }

                if ($user->isStudent()) {
                    return redirect()->route('student.dashboard');
                } elseif ($user->isTutor()) {
                    return redirect()->route('tutor.dashboard');
                } elseif ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                }
            }
            
            // New user - redirect to complete onboarding
            $role = session('oauth_role', 'student');
            session(['google_user_data' => [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
            ]]);
            
            if ($role === 'tutor') {
                return redirect()->route('register.tutor')->with('google_auth', true);
            } elseif ($role === 'parent') {
                return redirect()->route('register.parent')->with('google_auth', true);
            } else {
                return redirect()->route('register.student')->with('google_auth', true);
            }
            
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('login')
                ->withErrors(['error' => 'Unable to login with Google. Error: ' . $e->getMessage()]);
        }
    }
    public function showStudentOtp(Request $request)
    {
        $pending = session('pending_student_registration');
        if (!$pending) {
            return redirect()->route('register.student')->withErrors(['error' => 'Please fill the registration form first.']);
        }
        return view('auth.student-verify-otp', ['pending' => $pending, 'justVerified' => false]);
    }

    public function verifyStudentOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);
        $pending = session('pending_student_registration');
        if (!$pending) {
            return redirect()->route('register.student')->withErrors(['error' => 'Session expired. Please start again.']);
        }

        $expiresAt = Carbon::parse($pending['otp_expires_at'] ?? Carbon::now()->subMinute());
        if (Carbon::now()->greaterThan($expiresAt)) {
            return back()->withErrors(['otp' => 'OTP expired. Please restart registration.']);
        }

        if ($request->otp !== ($pending['otp'] ?? '')) {
            $pending['attempts'] = ($pending['attempts'] ?? 0) + 1;
            session(['pending_student_registration' => $pending]);
            return back()->withErrors(['otp' => 'Invalid code. Please try again.']);
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $pending['name'],
                'email' => $pending['email'],
                'role' => 'student',
                'password' => $pending['password_hash'],
                'email_verified_at' => now(),
            ]);

            StudentProfile::create([
                'user_id' => $user->id,
                'grade' => $pending['class_slab'],
                'location' => null,
                'pin_code' => null,
                'latitude' => null,
                'longitude' => null,
                'subjects_of_interest' => [],
            ]);

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 600.00,
                'total_credited' => 600.00,
                'total_debited' => 0.00,
            ]);

            DB::commit();
            session()->forget(['pending_student_registration']);
            Auth::login($user);

            // Return OTP page with success flag to show animation then redirect via JS
            return view('auth.student-verify-otp', ['pending' => null, 'justVerified' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Could not create your account. Please try again.']);
        }
    }

    public function submitStudentOtpIssue(Request $request)
    {
        $pending = session('pending_student_registration');
        $message = (string)($request->input('message'));
        // Save a minimal record for admin visibility
        try {
            \App\Models\RegistrationIssue::create([
                'name' => $pending['name'] ?? 'Unknown',
                'email' => $pending['email'] ?? ($request->input('email') ?? 'unknown@example.com'),
                'role' => 'student',
                'message' => $message,
                'payload' => $pending ? collect($pending)->except(['otp','password_hash'])->toArray() : [],
                'status' => 'open',
            ]);
        } catch (\Throwable $e) {
            // swallow errors; we don't block user here
        }
        return back()->with('issue_submitted', true);
    }
}
