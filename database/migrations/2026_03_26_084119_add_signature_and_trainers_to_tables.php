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
        Schema::table('training_participants', function (Blueprint $table) {
            $table->text('signature_path')->nullable()->after('is_present');
        });

        Schema::table('trainings', function (Blueprint $table) {
            $table->json('trainers')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_participants', function (Blueprint $table) {
            $table->dropColumn('signature_path');
        });

        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn('trainers');
        });
    }
};
