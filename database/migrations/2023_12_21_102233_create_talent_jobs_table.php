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
        Schema::create('talent_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->string('job_title');
            $table->string('slug');
            $table->string('country_id');
            $table->string('state_id');
            $table->string('job_type');
            $table->longText('description');
            $table->longText('responsibilities');
            $table->longText('required_skills');
            $table->longText('benefits')->nullable();
            $table->string('salaray_type');
            $table->string('salary_min');
            $table->string('salary_max');
            $table->json('skills');
            $table->string('experience');
            $table->string('qualification');
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_jobs');
    }
};
