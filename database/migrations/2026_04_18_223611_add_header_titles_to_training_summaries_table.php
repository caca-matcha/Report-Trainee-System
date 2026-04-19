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
            $table->string('prepared_header')->nullable()->after('prepared_barcode_path');
            $table->string('checked_header')->nullable()->after('checked_barcode_path');
            $table->string('confirmed_header')->nullable()->after('barcode_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_summaries', function (Blueprint $table) {
            $table->dropColumn(['prepared_header', 'checked_header', 'confirmed_header']);
        });
    }
};
