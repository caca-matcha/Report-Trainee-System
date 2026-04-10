<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('training_summaries', function (Blueprint $table) {
            $table->text('trainer_feedbacks')->nullable()->after('feedback_summary');
            $table->text('trainer_impressions')->nullable()->after('trainer_feedbacks');
        });
    }

    public function down(): void
    {
        Schema::table('training_summaries', function (Blueprint $table) {
            $table->dropColumn(['trainer_feedbacks', 'trainer_impressions']);
        });
    }
};
