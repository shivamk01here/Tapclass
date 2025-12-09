<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('role')->default('student');
            $table->string('avatar')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('google_id')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->integer('ai_test_credits')->default(200);
            $table->boolean('is_premium')->default(false);
            $table->timestamps();
        });

        // 2. Password Reset Tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. Failed Jobs
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // 5. Cities
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('state')->nullable();
            $table->string('country')->default('India');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. Languages
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->timestamps();
        });

        // 7. Subjects
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 8. Tutor Profiles
        Schema::create('tutor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('bio')->nullable();
            $table->integer('experience_years')->default(0);
            $table->string('education')->nullable();
            $table->string('qualification')->nullable();
            $table->string('location')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('gender')->nullable();
            $table->integer('travel_radius_km')->nullable();
            $table->json('grade_levels')->nullable();
            $table->string('government_id_path')->nullable();
            $table->string('degree_certificate_path')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('verification_status')->default('pending');
            $table->text('verification_notes')->nullable();
            $table->boolean('is_verified_badge')->default(false);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('total_sessions')->default(0);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_likes')->default(0);
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->string('teaching_mode')->default('both');
            $table->boolean('onboarding_completed')->default(false);
            $table->unsignedTinyInteger('onboarding_step')->default(0);
            $table->timestamps();
        });

        // 9. Student Profiles
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('grade')->nullable();
            $table->string('location')->nullable();
            $table->string('pin_code')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->unsignedBigInteger('city_id')->nullable()->index();
            $table->date('date_of_birth')->nullable();
            $table->json('subjects_of_interest')->nullable();
            $table->json('preferred_tutoring_modes')->nullable();
            $table->boolean('onboarding_completed')->default(false);
            $table->timestamps();
        });

        // 10. Tutor Subjects Pivot
        Schema::create('tutor_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_profile_id')->constrained('tutor_profiles')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->decimal('online_rate', 8, 2)->nullable();
            $table->decimal('offline_rate', 8, 2)->nullable();
            $table->boolean('is_online_available')->default(true);
            $table->boolean('is_offline_available')->default(true);
            $table->timestamps();
        });

        // 11. Tutor Profile Languages Pivot
        Schema::create('tutor_profile_language', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_profile_id')->constrained('tutor_profiles')->cascadeOnDelete();
            $table->foreignId('language_id')->constrained('languages')->cascadeOnDelete();
            $table->timestamps();
        });

        // 12. Parent Children
        Schema::create('parent_children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->integer('age')->nullable();
            $table->string('grade')->nullable();
            $table->string('school')->nullable();
            $table->timestamps();
        });

        // 13. Bookings
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('tutor_id')->constrained('users');
            $table->foreignId('subject_id')->nullable()->constrained('subjects');
            $table->string('session_type');
            $table->date('session_date');
            $table->time('session_start_time');
            $table->time('session_end_time');
            $table->integer('session_duration_minutes');
            $table->decimal('amount', 10, 2);
            $table->decimal('platform_commission', 10, 2)->default(0);
            $table->decimal('tutor_earnings', 10, 2);
            $table->string('status')->default('pending');
            $table->string('cancellation_reason')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->string('meet_link')->nullable();
            $table->string('location_address')->nullable();
            $table->decimal('location_latitude', 10, 8)->nullable();
            $table->decimal('location_longitude', 11, 8)->nullable();
            $table->foreignId('child_id')->nullable()->constrained('parent_children')->nullOnDelete();
            $table->string('child_name')->nullable();
            $table->unsignedTinyInteger('child_age')->nullable();
            $table->string('child_class_slab')->nullable();
            $table->timestamps();
        });

        // 14. Parent Consultations
        Schema::create('parent_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('topic');
            $table->text('message');
            $table->string('status')->default('open');
            $table->timestamps();
        });

        // 15. Registration Issues
        Schema::create('registration_issues', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('issue_description');
            $table->string('status')->default('open');
            $table->timestamps();
        });

        // 16. AI Mock Tests
        Schema::create('ai_mock_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('uuid')->unique()->nullable();
            $table->string('exam_context')->nullable();
            $table->string('subject');
            $table->string('topic');
            $table->string('difficulty');
            $table->json('questions_json')->nullable();
            $table->json('user_answers_json')->nullable();
            $table->integer('score')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->timestamps();
        });

        // 17. AI Payment Requests
        Schema::create('ai_payment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('plan');
            $table->decimal('amount', 10, 2);
            $table->string('utr')->nullable();
            $table->string('screenshot_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // 18. Reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->nullOnDelete();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('tutor_id')->constrained('users');
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        // 19. Tutor Earnings
        Schema::create('tutor_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('users');
            $table->foreignId('booking_id')->nullable()->constrained('bookings');
            $table->decimal('amount', 10, 2);
            $table->string('type');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        // 20. Tutor Likes
        Schema::create('tutor_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tutor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('student_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        // 21. Tutor Availability
        Schema::create('tutor_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_profile_id')->constrained('tutor_profiles')->cascadeOnDelete();
            $table->string('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });

        // 22. Wallets
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('balance', 10, 2)->default(0);
            $table->decimal('total_credited', 10, 2)->default(0);
            $table->decimal('total_debited', 10, 2)->default(0);
            $table->timestamps();
        });

        // 23. Wallet Transactions
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('wallets')->cascadeOnDelete();
            $table->string('transaction_type');
            $table->decimal('amount', 10, 2);
            $table->string('description')->nullable();
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->decimal('balance_before', 10, 2);
            $table->decimal('balance_after', 10, 2);
            $table->timestamps();
        });

        // 24. Messages
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // 25. Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type');
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // 26. Withdrawal Requests
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('users');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('wallet_transactions');
        Schema::dropIfExists('wallets');
        Schema::dropIfExists('tutor_availabilities');
        Schema::dropIfExists('tutor_likes');
        Schema::dropIfExists('tutor_earnings');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('ai_payment_requests');
        Schema::dropIfExists('ai_mock_tests');
        Schema::dropIfExists('registration_issues');
        Schema::dropIfExists('parent_consultations');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('parent_children');
        Schema::dropIfExists('tutor_profile_language');
        Schema::dropIfExists('tutor_subjects');
        Schema::dropIfExists('student_profiles');
        Schema::dropIfExists('tutor_profiles');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
