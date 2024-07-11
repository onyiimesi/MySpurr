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
        Schema::create('message_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id');
            $table->bigInteger('sender_id');
            $table->string('sender_type');
            $table->bigInteger('receiver_id');
            $table->string('receiver_type');
            $table->longText('message');
            $table->longText('attachment')->nullable();
            $table->dateTime('replied_at')->nullable();
            $table->enum('status', ['read', 'unread']);

            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_replies');
    }
};
