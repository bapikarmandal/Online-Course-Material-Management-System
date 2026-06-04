<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('materials', function (Blueprint $table) {
            $table->enum('material_type', [
                'study_material', 'previous_year_question', 'syllabus', 'assignment', 'other'
            ])->default('study_material')->after('semester');
            $table->string('drive_link')->nullable()->after('description');
            $table->boolean('is_active')->default(true)->after('drive_link');
        });
    }
    public function down(): void {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['material_type', 'drive_link', 'is_active']);
        });
    }
};