<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\AiMockTest;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ai_mock_tests', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->nullable()->unique();
        });

        // Backfill existing records
        $tests = AiMockTest::all();
        foreach ($tests as $test) {
            $test->uuid = (string) Str::uuid();
            $test->save();
        }

        // Make it required after backfilling
        Schema::table('ai_mock_tests', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_mock_tests', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
