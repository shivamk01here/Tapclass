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

            return redirect()->route('student.dashboard')->with('success', 'Registration successful! Welcome to TapClass.');
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

    public function registerTutor(Request $request)
    {
        $isGoogleAuth = $request->has('google_auth') && session('google_user_data');
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'bio' => 'required|string|min:50|max:500',
            'experience_years' => 'required|integer|min:0|max:50',
            'education' => 'required|string|max:500',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'government_id' => 'required|image|max:5120',
            'degree_certificate' => 'required|image|max:5120',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'subjects' => 'required|array|min:1',
            'subjects.*.subject_id' => 'required|exists:subjects,id',
            'subjects.*.online_rate' => 'nullable|numeric|min:0',
            'subjects.*.offline_rate' => 'nullable|numeric|min:0',
            'subjects.*.is_online_available' => 'boolean',
            'subjects.*.is_offline_available' => 'boolean',
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
                'role' => 'tutor',
                'email_verified_at' => now(),
                'profile_picture' => $profilePicturePath,
            ];
            
            if ($isGoogleAuth) {
                $userData['google_id'] = $googleData['google_id'];
                $userData['password'] = Hash::make(\Str::random(32));
            } else {
                $userData['password'] = Hash::make($request->password);
            }
            
            $user = User::create($userData);

            // Handle file uploads
            $governmentIdPath = null;
            $degreeCertificatePath = null;
            $cvPath = null;

            if ($request->hasFile('government_id')) {
                $governmentIdPath = $request->file('government_id')->store('uploads/tutors/government_ids', 'public');
            }

            if ($request->hasFile('degree_certificate')) {
                $degreeCertificatePath = $request->file('degree_certificate')->store('uploads/tutors/degrees', 'public');
            }
            
            if ($request->hasFile('cv')) {
                $cvPath = $request->file('cv')->store('uploads/tutors/cvs', 'public');
            }

            // Create tutor profile
            $tutorProfile = TutorProfile::create([
                'user_id' => $user->id,
                'bio' => $request->bio,
                'experience_years' => $request->experience_years,
                'education' => $request->education,
                'location' => $request->location,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'government_id_path' => $governmentIdPath,
                'degree_certificate_path' => $degreeCertificatePath,
                'cv_path' => $cvPath,
                'verification_status' => 'pending',
            ]);

            // Add subjects
            foreach ($request->subjects as $subjectData) {
                \App\Models\TutorSubject::create([
                    'tutor_profile_id' => $tutorProfile->id,
                    'subject_id' => $subjectData['subject_id'],
                    'online_rate' => $subjectData['online_rate'] ?? null,
                    'offline_rate' => $subjectData['offline_rate'] ?? null,
                    'is_online_available' => $subjectData['is_online_available'] ?? false,
                    'is_offline_available' => $subjectData['is_offline_available'] ?? false,
                ]);
            }

            DB::commit();
            
            // Clear Google session data
            session()->forget(['google_user_data', 'oauth_role']);

            // Log in the user
            Auth::login($user);

            return redirect()->route('tutor.onboarding')->with('success', 'Registration successful! Your profile is under review.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
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
