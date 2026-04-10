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
        Schema::table('master_trainings', function (Blueprint $table) {
            $table->json('pics')->nullable()->after('trainers');
        });

        Schema::table('trainings', function (Blueprint $table) {
            $table->json('pics')->nullable()->after('trainers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_trainings', function (Blueprint $table) {
            $table->dropColumn('pics');
        });

        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn('pics');
        });
    }
};
