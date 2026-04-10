<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing records first to avoid NULL constraint errors during change()
        DB::table('users')->update(['subco' => 'DP']);
        DB::table('training_participants')->update(['subco' => 'DP']);

        Schema::table('users', function (Blueprint $table) {
            $table->string('subco')->default('DP')->nullable()->change();
        });

        Schema::table('training_participants', function (Blueprint $table) {
            $table->string('subco')->default('DP')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('subco')->default(null)->nullable()->change();
        });

        Schema::table('training_participants', function (Blueprint $table) {
            $table->string('subco')->default(null)->nullable()->change();
        });
    }
};
