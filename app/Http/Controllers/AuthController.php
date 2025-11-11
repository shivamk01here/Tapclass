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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'grade' => 'nullable|string|max:50',
            'location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'subjects_of_interest' => 'nullable|array',
            'subjects_of_interest.*' => 'exists:subjects,id',
        ];
        
        // Password only required for non-Google registration
        if (!$isGoogleAuth) {
            $rules['password'] = 'required|min:6|confirmed';
        }
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $googleData = session('google_user_data');
            
            // Handle profile picture upload
            $profilePicturePath = null;
            if ($request->hasFile('profile_picture')) {
                $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            }
            
            // Create user
            $userData = [
                'name' => $isGoogleAuth ? $googleData['name'] : $request->name,
                'email' => $isGoogleAuth ? $googleData['email'] : $request->email,
                'phone' => $request->phone,
                'role' => 'student',
                'email_verified_at' => now(),
                'profile_picture' => $profilePicturePath,
            ];
            
            if ($isGoogleAuth) {
                $userData['google_id'] = $googleData['google_id'];
                $userData['password'] = Hash::make(\Str::random(32)); // Random password for Google users
            } else {
                $userData['password'] = Hash::make($request->password);
            }
            
            $user = User::create($userData);

            // Create student profile with subject preferences and location
            StudentProfile::create([
                'user_id' => $user->id,
                'grade' => $request->grade,
                'location' => $request->location,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'subjects_of_interest' => $request->subjects_of_interest ?? [],
            ]);

            // Create wallet with default balance
            Wallet::create([
                'user_id' => $user->id,
                'balance' => 10000.00,
                'total_credited' => 10000.00,
                'total_debited' => 0.00,
            ]);

            DB::commit();
            
            // Clear Google session data
            session()->forget(['google_user_data', 'oauth_role']);

            // Log in the user
            Auth::login($user);

            return redirect()->route('student.dashboard')->with('success', 'Registration successful! Welcome to Htc.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
        }
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ];
        
        if (!$isGoogleAuth) {
            $rules['password'] = 'required|min:6|confirmed';
        }
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $googleData = session('google_user_data');

            // Create user (minimal)
            $userData = [
                'name' => $isGoogleAuth ? $googleData['name'] : $request->name,
                'email' => $isGoogleAuth ? $googleData['email'] : $request->email,
                'role' => 'tutor',
                'email_verified_at' => now(),
            ];
            
            if ($isGoogleAuth) {
                $userData['google_id'] = $googleData['google_id'];
                $userData['password'] = Hash::make(\Str::random(32));
            } else {
                $userData['password'] = Hash::make($request->password);
            }

            $user = User::create($userData);

            // Create empty tutor profile to be filled during onboarding
            TutorProfile::create([
                'user_id' => $user->id,
                'verification_status' => 'pending',
                'onboarding_completed' => false,
                'onboarding_step' => 0,
            ]);

            DB::commit();
            
            // Clear Google session data
            session()->forget(['google_user_data', 'oauth_role']);

            // Log in the user
            Auth::login($user);

            // Send to dashboard; TutorOnboardMiddleware will redirect to onboarding until completed
            return redirect()->route('tutor.dashboard')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
        }
    }

    public function registerParent(Request $request)
    {
        $isGoogleAuth = $request->has('google_auth') && session('google_user_data');
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ];
        if (! $isGoogleAuth) {
            $rules['password'] = 'required|min:6|confirmed';
        }
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        \DB::beginTransaction();
        try {
            $googleData = session('google_user_data');
            $userData = [
                'name' => $isGoogleAuth ? $googleData['name'] : $request->name,
                'email' => $isGoogleAuth ? $googleData['email'] : $request->email,
                'role' => 'parent',
                'email_verified_at' => now(),
            ];
            if ($isGoogleAuth) {
                $userData['google_id'] = $googleData['google_id'] ?? null;
                $userData['password'] = \Hash::make(\Str::random(32));
            } else {
                $userData['password'] = \Hash::make($request->password);
            }
            $user = \App\Models\User::create($userData);
            \App\Models\Wallet::create([
                'user_id' => $user->id,
                'balance' => 0,
                'total_credited' => 0,
                'total_debited' => 0,
            ]);
            \DB::commit();
            // Clear Google session data
            session()->forget(['google_user_data','oauth_role']);
            \Auth::login($user);
            return redirect()->route('onboarding.parent.show')->with('success','Welcome! Add your first learner.');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withErrors(['error' => 'Registration failed: '.$e->getMessage()])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    // Google OAuth methods
    public function redirectToGoogle(Request $request)
    {
        // Store the intended role (student/tutor) in session
        if ($request->has('role')) {
            session(['oauth_role' => $request->role]);
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
}
