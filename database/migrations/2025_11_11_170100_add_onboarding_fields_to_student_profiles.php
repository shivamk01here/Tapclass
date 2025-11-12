<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('student_profiles', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('student_profiles', 'city_id')) {
                $table->unsignedBigInteger('city_id')->nullable()->after('location')->index();
            }
            if (!Schema::hasColumn('student_profiles', 'preferred_tutoring_modes')) {
                $table->json('preferred_tutoring_modes')->nullable()->after('subjects_of_interest');
            }
            if (!Schema::hasColumn('student_profiles', 'onboarding_completed')) {
                $table->boolean('onboarding_completed')->default(false)->after('preferred_tutoring_modes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('student_profiles', 'onboarding_completed')) {
                $table->dropColumn('onboarding_completed');
            }
            if (Schema::hasColumn('student_profiles', 'preferred_tutoring_modes')) {
                $table->dropColumn('preferred_tutoring_modes');
            }
            if (Schema::hasColumn('student_profiles', 'city_id')) {
                $table->dropColumn('city_id');
            }
            if (Schema::hasColumn('student_profiles', 'date_of_birth')) {
                $table->dropColumn('date_of_birth');
            }
        });
    }
};