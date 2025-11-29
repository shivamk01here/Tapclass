<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_mock_tests', function (Blueprint $table) {
            $table->integer('score')->nullable();
            $table->json('user_answers_json')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ai_mock_tests', function (Blueprint $table) {
            $table->dropColumn(['score', 'user_answers_json']);
        });
    }
};
