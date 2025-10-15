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
        Schema::table('site_settings', function (Blueprint $table) {
            // Page Under Contract Section
            $table->boolean('page_under_contract')->default(false)->after('maintenance_message');
            $table->text('under_contract_message')->nullable()->after('page_under_contract');

            // Achievement Section
            $table->integer('graduated_students')->nullable()->after('vision');
            $table->integer('qualified_teachers')->nullable()->after('graduated_students');
            $table->string('student_teacher_ratio')->nullable()->after('qualified_teachers');
            $table->integer('courses_offered')->nullable()->after('student_teacher_ratio');

            // Intro Video Section
            $table->string('intro_video_title')->nullable()->after('courses_offered');
            $table->string('intro_video_url')->nullable()->after('intro_video_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'page_under_contract',
                'under_contract_message',
                'graduated_students',
                'qualified_teachers',
                'student_teacher_ratio',
                'courses_offered',
                'intro_video_title',
                'intro_video_url',
            ]);
        });
    }
};
