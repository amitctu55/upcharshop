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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->string('reference_code', 20)->unique();
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->string('patient_name');
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->unsignedTinyInteger('age')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('doctor_id')->constrained();
            $table->date('appointment_date');
            $table->time('slot_time');
            $table->enum('visit_type', ['new', 'followup', 'video'])->default('new');
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'no_show'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->enum('source', ['online', 'walkin', 'phone', 'admin'])->default('online');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedSmallInteger('token_no')->nullable();
            $table->timestamps();
            $table->index(['hospital_id', 'appointment_date']);
            $table->index(['doctor_id', 'appointment_date', 'slot_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
