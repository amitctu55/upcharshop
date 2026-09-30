<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('hospital_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->foreignId('doctor_id')->nullable()->after('hospital_id')->constrained()->nullOnDelete();
            $table->string('phone', 30)->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['hospital_id']);
            $table->dropForeign(['doctor_id']);
            $table->dropColumn(['hospital_id', 'doctor_id', 'phone', 'avatar', 'is_active', 'last_login_at']);
        });
    }
};
