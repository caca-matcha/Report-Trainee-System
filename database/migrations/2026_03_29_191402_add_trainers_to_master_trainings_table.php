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
            $table->json('trainers')->nullable()->after('trainer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_trainings', function (Blueprint $table) {
            $table->dropColumn('trainers');
        });
    }
};
