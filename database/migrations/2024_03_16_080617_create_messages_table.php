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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->string('sender_type');
            $table->unsignedBigInteger('receiver_id');
            $table->string('receiver_type');
            $table->string('send_to');
            $table->string('subject');
            $table->longText('body');
            $table->string('cc')->nullable();
            $table->string('bcc')->nullable();
            $table->longText('attachment')->nullable();
            $table->boolean('is_draft')->default(false);
            $table->boolean('is_sent')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
