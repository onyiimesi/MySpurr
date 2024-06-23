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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_category_id');
            $table->string('title');
            $table->string('slug');
            $table->longText('description');
            $table->longText('content');
            $table->json('tags')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->string('featured_photo');
            $table->string('file_id')->nullable();
            $table->enum('status', ['active', 'inactive']);

            $table->index(['blog_category_id', 'slug']);

            $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
