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
        Schema::create('broad_cast_messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id');
            $table->string('subject');
            $table->string('brand');
            $table->longText('message');
            $table->string('type');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('broad_cast_message_id')->nullable()->after('id');
            $table->string('type')->nullable()->after('sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broad_cast_messages');
    }
};
