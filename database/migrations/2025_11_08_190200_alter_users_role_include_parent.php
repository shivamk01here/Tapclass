<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Try to widen enum to include 'parent'. If it's not ENUM, fallback to making it VARCHAR(20).
        try {
            DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('student','tutor','admin','parent') NOT NULL DEFAULT 'student'");
        } catch (\Throwable $e) {
            // Fallback: convert to VARCHAR(20)
            DB::statement("ALTER TABLE `users` MODIFY `role` VARCHAR(20) NOT NULL DEFAULT 'student'");
        }
    }

    public function down(): void
    {
        // Revert to original enum without 'parent' if it was enum; otherwise keep VARCHAR(20) to avoid breaking existing data
        try {
            DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('student','tutor','admin') NOT NULL DEFAULT 'student'");
        } catch (\Throwable $e) {
            // no-op
        }
    }
};
