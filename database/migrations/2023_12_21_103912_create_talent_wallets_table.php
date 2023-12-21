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
        Schema::create('talent_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('talent_id');
            $table->string('wallet_no');
            $table->float('current_bal', 10, 2);
            $table->float('previous_bal', 10, 2);
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
        Schema::dropIfExists('talent_wallets');
    }
};
