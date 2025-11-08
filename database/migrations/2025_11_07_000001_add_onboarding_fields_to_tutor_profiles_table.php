<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tutor_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('tutor_profiles', 'onboarding_completed')) {
                $table->boolean('onboarding_completed')->default(false)->after('verification_status');
            }
            if (!Schema::hasColumn('tutor_profiles', 'onboarding_step')) {
                $table->unsignedTinyInteger('onboarding_step')->default(0)->after('onboarding_completed');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tutor_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('tutor_profiles', 'onboarding_step')) {
                $table->dropColumn('onboarding_step');
            }
            if (Schema::hasColumn('tutor_profiles', 'onboarding_completed')) {
                $table->dropColumn('onboarding_completed');
            }
        });
    }
};