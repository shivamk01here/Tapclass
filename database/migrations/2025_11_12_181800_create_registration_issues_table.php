<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registration_issues', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->index();
            $table->string('role')->default('student');
            $table->text('message')->nullable();
            $table->json('payload')->nullable();
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_issues');
    }
};
