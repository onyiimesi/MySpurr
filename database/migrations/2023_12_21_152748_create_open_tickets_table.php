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
        Schema::create('open_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talent_id');
            $table->string('name', 255);
            $table->string('email');
            $table->string('subject');
            $table->string('department');
            $table->string('priority')->nullable();
            $table->string('zip')->nullable();
            $table->longText('message');
            $table->string('attachment', 255)->nullable();
            $table->string('status');

            $table->foreign('talent_id')->references('id')->on('talent')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_tickets');
    }
};
