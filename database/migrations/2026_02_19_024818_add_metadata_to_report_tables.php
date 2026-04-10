<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('organizer')->nullable()->after('title');
        });

        Schema::table('training_summaries', function (Blueprint $table) {
            $table->string('prepared_by')->nullable()->after('comment');
            $table->string('checked_by')->nullable()->after('prepared_by');
            $table->string('confirmed_by')->nullable()->after('checked_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn('organizer');
        });

        Schema::table('training_summaries', function (Blueprint $table) {
            $table->dropColumn(['prepared_by', 'checked_by', 'confirmed_by']);
        });
    }
};
