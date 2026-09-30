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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('photo')->nullable();
            $table->string('designation')->nullable();
            $table->string('qualifications')->nullable();
            $table->string('specialization')->nullable();
            $table->unsignedTinyInteger('experience_years')->nullable();
            $table->string('registration_no')->nullable();
            $table->longText('bio')->nullable();
            $table->decimal('consultation_fee', 10, 2)->nullable();
            $table->boolean('video_consult')->default(false);
            $table->json('social_links')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['hospital_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
