<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->decimal('budget', 10, 2, true)->default(0);
            $table->dateTimeTz('last_online')->nullable();
            $table->boolean('premium_user')->default(false);
            $table->uuid('user_tag');
            $table->enum('status', ['student', 'teacher', 'worker'])->nullable();
            $table->set('destiny', ['learning', 'qualification', 'development'])->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
