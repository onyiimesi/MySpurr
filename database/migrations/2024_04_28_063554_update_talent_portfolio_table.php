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
        if (!Schema::hasColumn('talent_portfolios', 'file_id')) {
            Schema::table('talent_portfolios', function (Blueprint $table) {
                $table->string('file_id')->nullable();
            });
        }

        if (!Schema::hasColumn('portfolio_project_images', 'file_id')) {
            Schema::table('portfolio_project_images', function (Blueprint $table) {
                $table->string('file_id')->nullable();
            });
        }
    }
};
