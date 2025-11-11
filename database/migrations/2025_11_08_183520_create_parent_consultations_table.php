<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('parent_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('child_id')->nullable()->constrained('parent_children')->nullOnDelete();
            $table->string('contact_phone')->nullable();
            $table->text('questions')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->string('status')->default('requested'); // requested/confirmed/cancelled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_consultations');
    }
};
