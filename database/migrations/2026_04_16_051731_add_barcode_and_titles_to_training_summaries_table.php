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
        Schema::table('training_summaries', function (Blueprint $table) {
            $table->string('barcode_path')->nullable()->after('training_id');
            $table->string('prepared_title')->nullable()->after('prepared_by');
            $table->string('checked_title')->nullable()->after('checked_by');
            $table->string('confirmed_title')->nullable()->after('confirmed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_summaries', function (Blueprint $table) {
            $table->dropColumn(['barcode_path', 'prepared_title', 'checked_title', 'confirmed_title']);
        });
    }
};
