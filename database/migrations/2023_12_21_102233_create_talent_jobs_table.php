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
            $table->bigInteger('business_id');
            $table->string('job_title');
            $table->string('location');
            $table->string('skills');
            $table->string('rate');
            $table->string('commitment');
            $table->string('job_type');
            $table->string('capacity');
            $table->string('experience');
            $table->longText('description');
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
        Schema::dropIfExists('talent_jobs');
    }
};
