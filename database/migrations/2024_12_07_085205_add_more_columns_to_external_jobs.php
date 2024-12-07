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
        Schema::table('external_jobs', function (Blueprint $table) {
            $table->string('salary_type')->after('salary_max')->nullable();
            $table->string('currency')->after('salary_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_jobs', function (Blueprint $table) {
            $table->dropColumn('salary_type');
            $table->dropColumn('currency');
        });
    }
};
