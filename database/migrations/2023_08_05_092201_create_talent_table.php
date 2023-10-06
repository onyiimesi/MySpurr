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
        Schema::create('talent', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->longText('overview')->nullable();
            $table->string('skill_title')->nullable();
            $table->string('top_skills')->nullable();
            $table->longText('location')->nullable();
            $table->string('highest_education')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('rate')->nullable();
            $table->string('availability')->nullable();
            $table->string('compensation')->nullable();
            $table->string('portfolio_title')->nullable();
            $table->longText('portfolio_description')->nullable();
            $table->string('image')->nullable();
            $table->string('social_media_link')->nullable();
            $table->string('password');
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->string('verify_status')->nullable();
            $table->string('type')->nullable();
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent');
    }
};
