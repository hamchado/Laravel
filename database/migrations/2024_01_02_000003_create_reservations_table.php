<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // الطالب
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('status', 20)->default('temporary'); // temporary, confirmed, cancelled
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('expires_at')->nullable(); // 24 hours from creation
            $table->timestamps();
            // Prevent duplicate active reservations
            $table->index(['patient_id', 'user_id', 'course_id', 'status']);
        });

        Schema::create('cancel_reasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('reason');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cancel_reasons');
        Schema::dropIfExists('reservations');
    }
};
