<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->decimal('passing_grade', 5, 2)->default(70)->after('training_type');
        });

        Schema::table('training_participants', function (Blueprint $table) {
            $table->decimal('pre_test_target', 5, 2)->default(70)->after('post_test_score');
            $table->decimal('post_test_target', 5, 2)->default(70)->after('pre_test_target');
            $table->decimal('punctuality_score', 5, 2)->nullable()->after('post_test_target');
            $table->decimal('punctuality_target', 5, 2)->default(2.00)->after('punctuality_score');
            $table->decimal('activeness_score', 5, 2)->nullable()->after('punctuality_target');
            $table->decimal('activeness_target', 5, 2)->default(2.00)->after('activeness_score');
            $table->decimal('cooperation_score', 5, 2)->nullable()->after('activeness_target');
            $table->decimal('cooperation_target', 5, 2)->default(2.00)->after('cooperation_score');
            $table->decimal('attitude_score', 5, 2)->nullable()->after('cooperation_target');
            $table->decimal('attitude_target', 5, 2)->default(2.00)->after('attitude_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn('passing_grade');
        });

        Schema::table('training_participants', function (Blueprint $table) {
            $table->dropColumn([
                'pre_test_target',
                'post_test_target',
                'punctuality_score',
                'punctuality_target',
                'activeness_score',
                'activeness_target',
                'cooperation_score',
                'cooperation_target',
                'attitude_score',
                'attitude_target'
            ]);
        });
    }
};
