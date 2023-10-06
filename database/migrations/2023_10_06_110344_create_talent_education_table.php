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
        Schema::create('talent_education', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talent_id');
            $table->string('school_name');
            $table->string('degree');
            $table->string('field_of_study');
            $table->string('start_date');
            $table->string('end_date');

            $table->foreign('talent_id')->references('id')->on('talent')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_education');
    }
};
