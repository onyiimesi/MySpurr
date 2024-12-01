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
            $table->string('salary_min')->after('required_skills')->nullable();
            $table->string('salary_max')->after('salary_min')->nullable();
            $table->dropColumn('salary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_jobs', function (Blueprint $table) {
            $table->dropColumn('salary_min');
            $table->dropColumn('salary_max');
            $table->string('salary')->nullable();
        });
    }
};
