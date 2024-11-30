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
        Schema::create('external_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('company_name');
            $table->string('location')->nullable();
            $table->string('job_type');
            $table->longText('description')->nullable();
            $table->longText('responsibilities');
            $table->longText('required_skills');
            $table->string('salary')->nullable();
            $table->string('link')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_jobs');
    }
};
