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
        Schema::create('talent_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talent_id');
            $table->string('title');
            $table->string('institute');
            $table->string('certificate_date');
            $table->string('certificate_year');
            $table->string('certificate_link')->nullable();
            $table->string('currently_working_here')->nullable();

            $table->foreign('talent_id')->references('id')->on('talent')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_certificates');
    }
};
