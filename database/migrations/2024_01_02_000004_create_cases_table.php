<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // الطالب
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('reservation_id')->nullable()->constrained()->onDelete('set null');
            $table->unsignedSmallInteger('tooth_number')->nullable();
            $table->string('treatment_type')->nullable(); // class2, simple, full, etc.
            $table->string('treatment_label')->nullable(); // حشوة كلاس 2
            $table->text('description')->nullable();
            $table->string('status', 20)->default('pending'); // pending, accepted, rejected
            $table->text('supervisor_notes')->nullable();
            $table->timestamp('evaluated_at')->nullable();
            $table->foreignId('evaluated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('case_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained()->onDelete('cascade');
            $table->string('path');
            $table->string('type')->nullable(); // before, after, xray
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_images');
        Schema::dropIfExists('cases');
    }
};
