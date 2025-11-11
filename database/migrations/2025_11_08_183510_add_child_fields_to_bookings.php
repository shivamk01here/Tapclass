<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('child_id')->nullable()->after('student_id')->constrained('parent_children')->nullOnDelete();
            $table->string('child_name')->nullable()->after('child_id');
            $table->unsignedTinyInteger('child_age')->nullable()->after('child_name');
            $table->string('child_class_slab')->nullable()->after('child_age');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('child_id');
            $table->dropColumn(['child_name','child_age','child_class_slab']);
        });
    }
};
