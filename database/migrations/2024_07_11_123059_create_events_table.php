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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->longText('speaker_bio');
            $table->string('speaker');
            $table->string('event_time');
            $table->string('event_date');
            $table->string('timezone');
            $table->string('address');
            $table->string('linkedln');
            $table->longText('content');
            $table->json('tags')->nullable();
            $table->string('featured_speaker');
            $table->string('file_id')->nullable();
            $table->string('featured_graphics');
            $table->string('featured_graphic_file_id')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->integer('is_published')->default(0);
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });

        Schema::create('event_brand_partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->string('image');
            $table->string('file_id')->nullable();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
