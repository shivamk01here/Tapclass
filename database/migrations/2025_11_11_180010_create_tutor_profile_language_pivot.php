<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('tutor_profile_language')) {
            Schema::create('tutor_profile_language', function (Blueprint $table) {
                $table->unsignedBigInteger('tutor_profile_id');
                $table->unsignedBigInteger('language_id');
                $table->primary(['tutor_profile_id','language_id']);
                $table->foreign('tutor_profile_id')->references('id')->on('tutor_profiles')->onDelete('cascade');
                $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_profile_language');
    }
};