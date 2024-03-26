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
        if (!Schema::hasColumn('talent_jobs', 'is_bookmark')) {
            Schema::table('talent_jobs', function (Blueprint $table) {
                $table->string('is_bookmark')->default(0);
            });
        }
    }
};
