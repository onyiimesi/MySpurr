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
        if(Schema::hasTable('talent_portfolios')) {
            Schema::drop('talent_portfolios');
        }

        Schema::create('talent_portfolios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talent_id');
            $table->string('title');
            $table->string('category_id');
            $table->longText('featured_image');
            $table->json('tags');
            $table->string('link');
            $table->longText('description');
            $table->enum('is_draft', ['true', 'false']);

            $table->foreign('talent_id')->references('id')->on('talent')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('portfolio_project_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talent_portfolio_id');
            $table->bigInteger('talent_id');
            $table->string('image');

            $table->foreign('talent_portfolio_id')->references('id')->on('talent_portfolios')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_portfolios');
    }
};
