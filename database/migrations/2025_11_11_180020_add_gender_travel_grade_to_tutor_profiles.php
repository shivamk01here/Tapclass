<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tutor_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('tutor_profiles', 'gender')) {
                $table->string('gender', 20)->nullable()->after('education');
            }
            if (!Schema::hasColumn('tutor_profiles', 'travel_radius_km')) {
                $table->unsignedSmallInteger('travel_radius_km')->nullable()->after('longitude');
            }
            if (!Schema::hasColumn('tutor_profiles', 'grade_levels')) {
                $table->json('grade_levels')->nullable()->after('qualification');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tutor_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('tutor_profiles', 'grade_levels')) {
                $table->dropColumn('grade_levels');
            }
            if (Schema::hasColumn('tutor_profiles', 'travel_radius_km')) {
                $table->dropColumn('travel_radius_km');
            }
            if (Schema::hasColumn('tutor_profiles', 'gender')) {
                $table->dropColumn('gender');
            }
        });
    }
};