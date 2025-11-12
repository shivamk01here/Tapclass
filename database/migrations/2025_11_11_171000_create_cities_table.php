<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('cities')) {
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('state')->nullable();
                $table->string('country', 100)->default('India');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });

            // Seed a few defaults
            DB::table('cities')->insert([
                ['name' => 'Lucknow', 'state' => 'Uttar Pradesh', 'country' => 'India', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Delhi', 'state' => 'Delhi', 'country' => 'India', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Gurgaon', 'state' => 'Haryana', 'country' => 'India', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Bangalore', 'state' => 'Karnataka', 'country' => 'India', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Gorakhpur', 'state' => 'Uttar Pradesh', 'country' => 'India', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};