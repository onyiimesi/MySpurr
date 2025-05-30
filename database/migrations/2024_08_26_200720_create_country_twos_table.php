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
        if(!Schema::hasTable('country_twos')){
            Schema::create('country_twos', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('iso2', 2)->unique();
                $table->string('iso3', 3)->unique();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_twos');
    }
};
