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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();                      // subdomain
            $table->string('custom_domain')->nullable()->unique();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('primary_color', 9)->default('#0E7C6B');
            $table->string('secondary_color', 9)->default('#093B33');
            $table->string('font_heading')->default('Bricolage Grotesque');
            $table->string('font_body')->default('Public Sans');
            $table->string('phone', 30)->nullable();
            $table->string('phone_2', 30)->nullable();
            $table->string('emergency_phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('map_embed')->nullable();
            $table->json('working_hours')->nullable();
            $table->json('social_links')->nullable();
            $table->json('hero_settings')->nullable();
            $table->json('appointment_settings')->nullable();
            $table->json('notification_settings')->nullable();
            $table->json('seo')->nullable();
            $table->string('timezone')->default('Asia/Kolkata');
            $table->enum('status', ['active', 'suspended', 'maintenance'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
