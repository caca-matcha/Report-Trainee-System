<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_trainings', function (Blueprint $table) {
            $table->unsignedBigInteger('training_id')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('master_trainings', function (Blueprint $table) {
            $table->dropColumn('training_id');
        });
    }
};
