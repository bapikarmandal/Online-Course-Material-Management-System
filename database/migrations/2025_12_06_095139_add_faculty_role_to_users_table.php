<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // FIX: Ensure 'student' is in the enum list instead of the conflicting 'user'.
            $table->enum('role', ['student', 'faculty', 'admin'])->default('student')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // FIX: Rollback uses 'student' for consistency.
            $table->enum('role', ['student', 'admin'])->default('student')->change();
        });
    }
};