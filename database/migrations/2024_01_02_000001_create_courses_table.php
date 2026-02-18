<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10); // A, B, C, D
            $table->string('slug')->unique(); // restorative4, exodontia4, etc.
            $table->string('name'); // مداواة الأسنان الترميمية 4
            $table->string('supervisors')->nullable();
            $table->string('schedule')->nullable(); // السبت 8:00 - 12:00
            $table->string('location')->nullable(); // عيادة الترميم 10
            $table->unsignedInteger('max_reservations')->default(2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Course-student pivot
        Schema::create('course_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['course_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_student');
        Schema::dropIfExists('courses');
    }
};
