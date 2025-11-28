<?php

// Load Laravel application
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

echo "Checking database status...\n";

// 1. Check/Create ai_mock_tests table
if (!Schema::hasTable('ai_mock_tests')) {
    echo "Creating ai_mock_tests table...\n";
    Schema::create('ai_mock_tests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('exam_context')->nullable();
        $table->string('subject');
        $table->string('topic');
        $table->string('difficulty');
        $table->json('questions_json')->nullable();
        $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
        $table->timestamps();
    });
    echo "ai_mock_tests table created.\n";
} else {
    echo "ai_mock_tests table already exists.\n";
}

// 2. Check/Add ai_test_credits to users
if (Schema::hasTable('users')) {
    if (!Schema::hasColumn('users', 'ai_test_credits')) {
        echo "Adding ai_test_credits to users table...\n";
        Schema::table('users', function (Blueprint $table) {
            $table->integer('ai_test_credits')->default(3)->after('email');
        });
        echo "ai_test_credits column added.\n";
    } else {
        echo "ai_test_credits column already exists.\n";
    }
    
    // 3. Reset credits to 10 for all users (as requested)
    DB::table('users')->update(['ai_test_credits' => 10]);
    echo "All users credited with 10 credits.\n";
} else {
    echo "Error: users table not found!\n";
}

echo "Database fix completed.\n";
