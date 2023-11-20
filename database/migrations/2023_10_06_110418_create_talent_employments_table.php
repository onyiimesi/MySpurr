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
        Schema::create('talent_employments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talent_id');
            $table->string('company_name');
            $table->string('title');
            $table->string('employment_type');
            $table->string('start_date');
            $table->string('end_date');
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('talent_employments');
    }
};
