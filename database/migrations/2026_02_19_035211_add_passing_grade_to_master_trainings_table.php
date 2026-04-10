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
        Schema::table('master_trainings', function (Blueprint $table) {
            $table->decimal('passing_grade', 5, 2)->default(70.00)->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_trainings', function (Blueprint $table) {
            $table->dropColumn('passing_grade');
        });
    }
};
