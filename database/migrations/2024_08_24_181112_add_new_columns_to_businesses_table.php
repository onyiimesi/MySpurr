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
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('facebook')->after('terms')->nullable();
            $table->string('twitter')->after('facebook')->nullable();
            $table->string('instagram')->after('twitter')->nullable();
            $table->string('behance')->after('instagram')->nullable();
            $table->string('size')->after('behance')->nullable();
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
