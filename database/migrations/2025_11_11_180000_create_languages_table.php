<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('languages')) {
            Schema::create('languages', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('code', 10)->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            DB::table('languages')->insert([
                ['name' => 'English', 'code' => 'en', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Hindi', 'code' => 'hi', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Bengali', 'code' => 'bn', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};