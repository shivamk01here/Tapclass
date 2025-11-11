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

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Static Pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');

Route::view('/register', 'auth.register')->name('register');


// Public Tutor Routes
Route::get('/tutors', [HomeController::class, 'searchTutors'])->name('tutors.search');
Route::get('/tutors/{id}', [HomeController::class, 'tutorProfile'])->name('tutors.profile');
Route::get('/booking/create/{tutorId}', [BookingController::class, 'create'])->name('booking.create')->middleware('auth');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register/student', [AuthController::class, 'showStudentRegister'])->name('register.student')->middleware('guest');
Route::post('/register/student', [AuthController::class, 'registerStudent'])->middleware('guest');

Route::get('/register/tutor', [AuthController::class, 'showTutorRegister'])->name('register.tutor')->middleware('guest');
Route::post('/register/tutor', [AuthController::class, 'registerTutor'])->middleware('guest');

// Parent register (minimal like tutor/student)
Route::get('/register/parent', [AuthController::class, 'showParentRegister'])->name('register.parent')->middleware('guest');
Route::post('/register/parent', [AuthController::class, 'registerParent'])->middleware('guest');

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/find-tutor', [StudentController::class, 'findTutor'])->name('find-tutor');
    Route::get('/tutor/{id}', [StudentController::class, 'tutorProfile'])->name('tutor.profile');
    Route::get('/bookings', [StudentController::class, 'bookings'])->name('bookings');
    Route::get('/wishlist', [StudentController::class, 'wishlist'])->name('wishlist');
    Route::get('/wallet', [StudentController::class, 'wallet'])->name('wallet');
    Route::get('/notifications', [StudentController::class, 'notifications'])->name('notifications');
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
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

    // Booking (parent-specific aliases for clarity; also available via public booking.create)
    Route::get('/booking/create/{tutorId}', [\App\Http\Controllers\BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [\App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');

    // Learners management
    Route::get('/learners', [\App\Http\Controllers\ParentLearnerController::class, 'index'])->name('learners');
    Route::post('/learners', [\App\Http\Controllers\ParentLearnerController::class, 'store'])->name('learners.store');
    Route::post('/learners/{child}', [\App\Http\Controllers\ParentLearnerController::class, 'update'])->name('learners.update');
    Route::delete('/learners/{child}', [\App\Http\Controllers\ParentLearnerController::class, 'destroy'])->name('learners.delete');
    Route::post('/child/switch', [\App\Http\Controllers\ParentLearnerController::class, 'switch'])->name('child.switch');

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
    
    // Bookings
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    
    // Payouts
    Route::get('/payouts', [AdminController::class, 'payouts'])->name('payouts');
    Route::post('/payouts/approve/{id}', [AdminController::class, 'approvePayout'])->name('payouts.approve');
    Route::post('/payouts/reject/{id}', [AdminController::class, 'rejectPayout'])->name('payouts.reject');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings/update', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
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
