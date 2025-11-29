<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AiTestController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
// Redirect any /home -> /
Route::permanentRedirect('/home', '/');

// Subject suggestions (public)
Route::get('/subjects/suggest', [\App\Http\Controllers\StudentOnboardingController::class, 'suggestSubjects'])->name('subjects.suggest');
// Languages suggestions and creation
Route::get('/languages/suggest', [\App\Http\Controllers\TutorController::class, 'suggestLanguages'])->name('languages.suggest');
Route::post('/languages', [\App\Http\Controllers\TutorController::class, 'createLanguage'])->middleware('auth')->name('languages.create');
// City suggestions
Route::get('/cities/suggest', [HomeController::class, 'suggestCities'])->name('cities.suggest');

// Static Pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');
Route::get('/careers', [HomeController::class, 'careers'])->name('careers');
Route::get('/careers/{id}', [HomeController::class, 'careerDetail'])->name('careers.detail');

Route::view('/register', 'auth.register')->name('register');


// Public Tutor Routes
Route::get('/tutors', [HomeController::class, 'searchTutors'])->name('tutors.search');
Route::get('/tutors/{id}', [HomeController::class, 'tutorProfile'])->name('tutors.profile');
Route::get('/booking/create/{tutorId}', [BookingController::class, 'create'])->name('booking.create')->middleware('auth');

// AI Mock Test Module
Route::get('/ai-mock-tests', [App\Http\Controllers\AiTestController::class, 'landing'])->name('ai-test.landing');
Route::get('/ai-mock-tests/create', [App\Http\Controllers\AiTestController::class, 'create'])->name('ai-test.create');
    Route::post('/ai-test/validate-exam', [App\Http\Controllers\AiTestController::class, 'validateExam'])->name('ai-test.validate-exam');
    Route::get('/ai-test/{id}/status', [App\Http\Controllers\AiTestController::class, 'checkStatus'])->name('ai-test.status');
    Route::post('/ai-test/validate', [App\Http\Controllers\AiTestController::class, 'validateTopic'])->name('ai-test.validate');
Route::post('/ai-mock-tests/generate', [App\Http\Controllers\AiTestController::class, 'generate'])->name('ai-test.generate')->middleware('auth');

Route::post('/ai-mock-tests/generate', [App\Http\Controllers\AiTestController::class, 'generate'])->name('ai-test.generate')->middleware('auth');

    Route::get('/ai-test/pricing', [AiTestController::class, 'pricing'])->name('ai-test.pricing');
    Route::post('/ai-test/purchase', [AiTestController::class, 'purchase'])->name('ai-test.purchase');
    Route::get('/ai-test/create', [AiTestController::class, 'create'])->name('ai-test.create');
Route::get('/ai-test/attempt/{uuid}', [AiTestController::class, 'attempt'])->name('ai-test.attempt');
Route::get('/ai-test/{uuid}/questions', [AiTestController::class, 'getQuestions'])->name('ai-test.questions'); // New Route
Route::post('/ai-test/submit/{uuid}', [AiTestController::class, 'submit'])->name('ai-test.submit')->middleware('auth');
Route::get('/ai-mock-tests/view/{uuid}', [App\Http\Controllers\AiTestController::class, 'show'])->name('ai-test.show')->middleware('auth');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot password via OTP
Route::get('/password/forgot', [AuthController::class, 'showForgot'])->name('password.forgot')->middleware('guest');
Route::post('/password/forgot', [AuthController::class, 'sendForgotOtp'])->name('password.forgot.send')->middleware('guest');
Route::get('/password/reset-otp', [AuthController::class, 'showResetOtp'])->name('password.reset-otp.show')->middleware('guest');
Route::post('/password/reset-otp', [AuthController::class, 'resetPasswordWithOtp'])->name('password.reset-otp.submit')->middleware('guest');

Route::get('/register/student', [AuthController::class, 'showStudentRegister'])->name('register.student')->middleware('guest');
Route::post('/register/student', [AuthController::class, 'registerStudent'])->middleware('guest');
// Student email OTP verification (non-Google flow)
Route::get('/register/student/verify-otp', [AuthController::class, 'showStudentOtp'])->name('register.student.verify-otp.show')->middleware('guest');
Route::post('/register/student/verify-otp', [AuthController::class, 'verifyStudentOtp'])->name('register.student.verify-otp.verify')->middleware('guest');
Route::post('/register/student/otp-issue', [AuthController::class, 'submitStudentOtpIssue'])->name('register.student.otp-issue')->middleware('guest');

Route::get('/register/tutor', [AuthController::class, 'showTutorRegister'])->name('register.tutor')->middleware('guest');
Route::post('/register/tutor', [AuthController::class, 'registerTutor'])->middleware('guest');
// Tutor email OTP verification (non-Google flow)
Route::get('/register/tutor/verify-otp', [AuthController::class, 'showTutorOtp'])->name('register.tutor.verify-otp.show')->middleware('guest');
Route::post('/register/tutor/verify-otp', [AuthController::class, 'verifyTutorOtp'])->name('register.tutor.verify-otp.verify')->middleware('guest');
Route::post('/register/tutor/otp-issue', [AuthController::class, 'submitTutorOtpIssue'])->name('register.tutor.otp-issue')->middleware('guest');

// Parent register (minimal like tutor/student)
Route::get('/register/parent', [AuthController::class, 'showParentRegister'])->name('register.parent')->middleware('guest');
Route::post('/register/parent', [AuthController::class, 'registerParent'])->middleware('guest');
// Parent email OTP verification (non-Google flow)
Route::get('/register/parent/verify-otp', [AuthController::class, 'showParentOtp'])->name('register.parent.verify-otp.show')->middleware('guest');
Route::post('/register/parent/verify-otp', [AuthController::class, 'verifyParentOtp'])->name('register.parent.verify-otp.verify')->middleware('guest');
Route::post('/register/parent/otp-issue', [AuthController::class, 'submitParentOtpIssue'])->name('register.parent.otp-issue')->middleware('guest');

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

// Student onboarding routes (accessible before completion)
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
Route::get('/onboarding', [\App\Http\Controllers\StudentOnboardingController::class, 'show'])->name('onboarding');
Route::post('/onboarding/step1', [\App\Http\Controllers\StudentOnboardingController::class, 'saveStep1'])->name('onboarding.step1');
Route::post('/onboarding/step2', [\App\Http\Controllers\StudentOnboardingController::class, 'saveStep2'])->name('onboarding.step2');
});

// Student app routes (require onboarding completed)
Route::middleware(['auth', 'role:student','student.onboarded'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::get('/tutor/{id}', [StudentController::class, 'tutorProfile'])->name('tutor.profile');
    Route::get('/bookings', [StudentController::class, 'bookings'])->name('bookings');
    Route::get('/wishlist', [StudentController::class, 'wishlist'])->name('wishlist');
    Route::get('/wallet', [StudentController::class, 'wallet'])->name('wallet');
    Route::get('/notifications', [StudentController::class, 'notifications'])->name('notifications');
    Route::get('/notifications/json', [StudentController::class, 'notificationsJson'])->name('notifications.json');
    Route::post('/settings/picture', [StudentController::class, 'updatePicture'])->name('settings.picture');
    Route::post('/profile/update', [StudentController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [StudentController::class, 'settings'])->name('settings');
    Route::post('/settings/password', [StudentController::class, 'updatePassword'])->name('settings.password');
    Route::post('/settings/picture', [StudentController::class, 'updatePicture'])->name('settings.picture');
    
    // Booking
    Route::get('/booking/create/{tutorId}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::post('/booking/{id}/reschedule', [BookingController::class, 'reschedule'])->name('booking.reschedule');
    
    // Like/Unlike
    Route::post('/tutor/{id}/toggle-like', [StudentController::class, 'toggleLike'])->name('tutor.toggle-like');
    
    // Reviews
    Route::get('/review/create/{booking}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/store/{booking}', [ReviewController::class, 'store'])->name('review.store');
    Route::post('/review/tutor/{tutorId}', [ReviewController::class, 'storeFromProfile'])->name('review.store');
});

    Route::post('/review/store/{booking}', [ReviewController::class, 'store'])->name('reviews.store');

/*
|--------------------------------------------------------------------------
| Parent Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:parent'])->prefix('parent')->name('parent.')->group(function(){
    // Onboarding
    Route::get('/onboarding', [\App\Http\Controllers\ParentOnboardingController::class, 'show'])->name('onboarding')->withoutMiddleware('parent.onboarded');
});

// Separate onboarding routes (before parent.onboarded)
Route::middleware(['auth','role:parent'])->group(function(){
    Route::get('/onboarding/parent', [\App\Http\Controllers\ParentOnboardingController::class, 'show'])->name('onboarding.parent.show');
    Route::post('/onboarding/parent/child', [\App\Http\Controllers\ParentOnboardingController::class, 'storeChild'])->name('onboarding.parent.child.store');
    Route::get('/onboarding/parent/consultation', [\App\Http\Controllers\ParentOnboardingController::class, 'consultationPrompt'])->name('onboarding.parent.consultation');
    Route::post('/onboarding/parent/consultation', [\App\Http\Controllers\ParentOnboardingController::class, 'storeConsultation'])->name('onboarding.parent.consultation.store');
});

// Parent app area (requires onboarded and active child set)
Route::middleware(['auth','role:parent','parent.onboarded','parent.active_child'])->prefix('parent')->name('parent.')->group(function(){
    Route::get('/', [\App\Http\Controllers\ParentDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\ParentDashboardController::class, 'dashboard'])->name('dashboard.alt');

    // Wishlist
    Route::get('/wishlist', [\App\Http\Controllers\ParentDashboardController::class, 'wishlist'])->name('wishlist');
    Route::post('/tutor/{id}/toggle-like', [\App\Http\Controllers\ParentDashboardController::class, 'toggleLike'])->name('tutor.toggle-like');

    // Booking (parent-specific aliases for clarity; also available via public booking.create)
    Route::get('/booking/create/{tutorId}', [\App\Http\Controllers\BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [\App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');

    // Learners management
    Route::get('/learners', [\App\Http\Controllers\ParentLearnerController::class, 'index'])->name('learners');
    Route::post('/learners', [\App\Http\Controllers\ParentLearnerController::class, 'store'])->name('learners.store');
    Route::post('/learners/{child}', [\App\Http\Controllers\ParentLearnerController::class, 'update'])->name('learners.update');
    Route::delete('/learners/{child}', [\App\Http\Controllers\ParentLearnerController::class, 'destroy'])->name('learners.delete');
    Route::post('/child/switch', [\App\Http\Controllers\ParentLearnerController::class, 'switch'])->name('child.switch');

    // Wallet
    Route::get('/wallet', [\App\Http\Controllers\ParentDashboardController::class, 'wallet'])->name('wallet');

    // Consultation (view/manage)
    Route::get('/consultation', [\App\Http\Controllers\ParentOnboardingController::class, 'consultationPrompt'])->name('consultation');
});

/*
|--------------------------------------------------------------------------
| Tutor Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:tutor'])->prefix('tutor')->name('tutor.')->group(function () {
    // Onboarding routes (accessible before onboarding completion)
    Route::get('/onboarding', [TutorController::class, 'onboarding'])->name('onboarding');
    Route::post('/onboarding/save-step', [TutorController::class, 'saveOnboardingStep'])->name('onboarding.save-step');
    Route::post('/onboarding/verify-otp', [TutorController::class, 'verifyOnboardingOtp'])->name('onboarding.verify-otp');

    // Pending verification view
    Route::get('/pending', [TutorController::class, 'pending'])->name('pending');

    // All other tutor routes require onboarding completion and will redirect to pending if not verified
    Route::middleware(['tutor.onboarded', 'tutor.verification'])->group(function () {
        Route::get('/dashboard', [TutorController::class, 'dashboard'])->name('dashboard');

        // Only verified tutors can access these
        Route::middleware('verified.tutor')->group(function () {
            Route::get('/bookings', [TutorController::class, 'bookings'])->name('bookings');
            Route::post('/booking/{id}/cancel', [BookingController::class, 'tutorCancel'])->name('booking.cancel');
            Route::get('/earnings', [TutorController::class, 'earnings'])->name('earnings');
            Route::post('/earnings/withdraw', [TutorController::class, 'requestWithdrawal'])->name('earnings.withdraw');
            Route::get('/availability', [TutorController::class, 'availability'])->name('availability');
            Route::post('/availability/save', [TutorController::class, 'saveAvailability'])->name('availability.save');
            Route::get('/notifications/json', [TutorController::class, 'notificationsJson'])->name('notifications.json');
        });
        
        Route::get('/profile', [TutorController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [TutorController::class, 'updateProfile'])->name('profile.update');
        Route::get('/reviews', [TutorController::class, 'reviews'])->name('reviews');
        Route::get('/notifications', [TutorController::class, 'notifications'])->name('notifications');
        Route::post('/settings/picture', [TutorController::class, 'updatePicture'])->name('settings.picture');
        Route::post('/settings/password', [TutorController::class, 'updatePassword'])->name('settings.password');

        Route::post('/bookings/{booking}/approve', [TutorController::class, 'approveBooking'])
            ->name('booking.approve');

        // For cancelling a pending/upcoming booking
        Route::post('/bookings/{booking}/cancel', [TutorController::class, 'cancelBooking'])
            ->name('booking.cancel');

        // For marking an upcoming session as completed
        Route::post('/bookings/{booking}/complete', [TutorController::class, 'completeBooking'])
            ->name('booking.complete');
            
        // For approving payment on a past session
        Route::post('/bookings/{booking}/approve-payment', [TutorController::class, 'approvePayment'])
            ->name('booking.approve-payment');

        // For the AJAX call to update the meeting link
        Route::post('/bookings/{booking}/update-link', [TutorController::class, 'updateMeetLink'])
            ->name('booking.updateLink'); // This name must match the AJAX route
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Tutor Management
    Route::get('/tutors', [AdminController::class, 'tutors'])->name('tutors');
    Route::get('/tutors/verify/{id}', [AdminController::class, 'verifyTutor'])->name('tutors.verify');
    Route::post('/tutors/approve/{id}', [AdminController::class, 'approveTutor'])->name('tutors.approve');
    Route::post('/tutors/reject/{id}', [AdminController::class, 'rejectTutor'])->name('tutors.reject');
    Route::post('/tutors/{id}/ban', [AdminController::class, 'banTutor'])->name('tutors.ban');
    
    // Student Management
    Route::get('/students', [AdminController::class, 'students'])->name('students');
    Route::post('/students/{id}/adjust-wallet', [AdminController::class, 'adjustWallet'])->name('students.adjust-wallet');

    // Parent Management
    Route::get('/parents', [AdminController::class, 'parents'])->name('parents');
    Route::get('/parents/{id}', [AdminController::class, 'parentShow'])->name('parents.show');
    
    // Bookings
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    
    // Payouts
    Route::get('/payouts', [AdminController::class, 'payouts'])->name('payouts');
    Route::post('/payouts/approve/{id}', [AdminController::class, 'approvePayout'])->name('payouts.approve');
    Route::post('/payouts/reject/{id}', [AdminController::class, 'rejectPayout'])->name('payouts.reject');

    // Consultation Requests
    Route::get('/consultations', [AdminController::class, 'consultations'])->name('consultations');
    Route::post('/consultations/{id}/status', [AdminController::class, 'updateConsultationStatus'])->name('consultations.status');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings/update', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');

    // Registration issues (failed/complaints during signup)
    Route::get('/registration-issues', [AdminController::class, 'registrationIssues'])->name('registration-issues');
    Route::post('/registration-issues/{id}/resolve', [AdminController::class, 'resolveRegistrationIssue'])->name('registration-issues.resolve');
});

/*
|--------------------------------------------------------------------------
| Message Routes (Shared between Student and Tutor)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/chat/{user}', [MessageController::class, 'chat'])->name('messages.chat');
    Route::post('/messages/send/{user}', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/messages/fetch/{user}', [MessageController::class, 'fetch'])->name('messages.fetch');
});
