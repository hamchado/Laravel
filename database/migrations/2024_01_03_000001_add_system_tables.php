<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ===== مواعيد فئات المقررات =====
        Schema::create('course_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('group_name')->nullable(); // المجموعة أ، ب، etc.
            $table->string('day_of_week'); // saturday, sunday, monday, etc.
            $table->time('start_time');
            $table->time('end_time');
            $table->string('location')->nullable();
            $table->timestamps();
        });

        // ===== قواعد المقرر =====
        Schema::create('course_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('max_cases_per_session')->default(2);
            $table->boolean('allow_grants')->default(true);
            $table->boolean('grant_unlimited')->default(true);
            $table->boolean('prevent_duplicate_tooth')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique('course_id');
        });

        // ===== مراحل التقييم =====
        Schema::create('case_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained()->onDelete('cascade');
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade');
            $table->unsignedTinyInteger('stage'); // 1, 2, 3
            $table->string('stage_name')->nullable(); // اسم المرحلة
            $table->string('grade')->nullable(); // ممتاز، جيد جداً، جيد، مقبول، راسب
            $table->text('notes')->nullable();
            $table->timestamp('evaluated_at')->nullable();
            $table->timestamps();
            $table->unique(['case_id', 'stage']);
        });

        // ===== سجل المنح =====
        Schema::create('case_grants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained()->onDelete('cascade');
            $table->foreignId('granter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('grantee_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('status', 20)->default('pending'); // pending, accepted, rejected, cancelled
            $table->text('cancel_reason')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });

        // ===== صور البانوراما =====
        Schema::create('panorama_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->string('path');
            $table->text('notes')->nullable();
            $table->date('taken_at')->nullable();
            $table->timestamps();
        });

        // ===== مراحل تقييم المقرر (تعريف المراحل) =====
        Schema::create('course_evaluation_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('stage_number'); // 1, 2, 3
            $table->string('stage_name'); // فحص أولي، تنفيذ، متابعة
            $table->unsignedTinyInteger('required_images')->default(0);
            $table->boolean('requires_panorama')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['course_id', 'stage_number']);
        });

        // ===== تعديلات على الجداول الموجودة =====

        // cases: إضافة أعمدة
        Schema::table('cases', function (Blueprint $table) {
            $table->boolean('is_grant')->default(false)->after('status');
            $table->unsignedTinyInteger('evaluation_count')->default(0)->after('is_grant');
            $table->date('session_date')->nullable()->after('evaluation_count');
        });

        // courses: إضافة حد الجلسة
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedSmallInteger('session_limit')->default(2)->after('max_reservations');
        });

        // course_student: إضافة اسم المجموعة
        Schema::table('course_student', function (Blueprint $table) {
            $table->string('group_name')->nullable()->after('user_id');
        });

        // otp_codes: إضافة رقم الهاتف وطريقة الإرسال
        Schema::table('otp_codes', function (Blueprint $table) {
            $table->string('phone_number', 20)->nullable()->after('code');
            $table->string('delivery_method', 20)->default('manual')->after('phone_number');
        });

        // users: إضافة رقم الهاتف
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
        });

        // course_works: إضافة أعمدة التقييم
        Schema::table('course_works', function (Blueprint $table) {
            $table->unsignedTinyInteger('evaluation_stages')->default(3)->after('required_count');
            $table->unsignedTinyInteger('required_images')->default(2)->after('evaluation_stages');
            $table->boolean('requires_panorama')->default(false)->after('required_images');
            $table->text('description')->nullable()->after('requires_panorama');
        });
    }

    public function down(): void
    {
        // إزالة الأعمدة المضافة
        Schema::table('course_works', function (Blueprint $table) {
            $table->dropColumn(['evaluation_stages', 'required_images', 'requires_panorama', 'description']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
        });

        Schema::table('otp_codes', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'delivery_method']);
        });

        Schema::table('course_student', function (Blueprint $table) {
            $table->dropColumn('group_name');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('session_limit');
        });

        Schema::table('cases', function (Blueprint $table) {
            $table->dropColumn(['is_grant', 'evaluation_count', 'session_date']);
        });

        // حذف الجداول الجديدة
        Schema::dropIfExists('course_evaluation_stages');
        Schema::dropIfExists('panorama_images');
        Schema::dropIfExists('case_grants');
        Schema::dropIfExists('case_evaluations');
        Schema::dropIfExists('course_rules');
        Schema::dropIfExists('course_schedules');
    }
};
