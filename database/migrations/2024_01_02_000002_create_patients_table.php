<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('record_number')->unique();
            $table->string('full_name');
            $table->string('phone', 20)->nullable();
            $table->unsignedSmallInteger('birth_year')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('gender', 10)->default('male'); // male, female
            $table->string('age_type', 10)->default('adult'); // adult, child
            $table->string('access_type', 10)->default('private'); // private, public, custom
            $table->string('governorate')->nullable();
            $table->string('address')->nullable();
            $table->text('notes')->nullable();
            // Parent info for children
            $table->string('parent_name')->nullable();
            $table->string('parent_phone', 20)->nullable();
            $table->unsignedSmallInteger('parent_birth_year')->nullable();
            // Who added this patient
            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Access permissions for custom type
        Schema::create('patient_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['patient_id', 'user_id']);
        });

        Schema::create('patient_teeth', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('tooth_number'); // FDI number
            $table->string('condition'); // restorative, endodontic, extraction, missing
            $table->string('sub_condition')->nullable(); // class1, class2, simple, surgical, etc.
            $table->string('label')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->unique(['patient_id', 'tooth_number']);
        });

        Schema::create('patient_perio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('segment'); // upper-right, upper-front, etc.
            $table->string('grade'); // healthy, mild, moderate, severe
            $table->json('pockets')->nullable(); // array of pocket depths
            $table->timestamps();
            $table->unique(['patient_id', 'segment']);
        });

        Schema::create('patient_health', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->json('diseases')->nullable(); // array of disease names
            $table->boolean('diabetes_controlled')->nullable();
            $table->boolean('bp_controlled')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_health');
        Schema::dropIfExists('patient_perio');
        Schema::dropIfExists('patient_teeth');
        Schema::dropIfExists('patient_access');
        Schema::dropIfExists('patients');
    }
};
