<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('event_no')->unique();          // TREV-2602-0001
            $table->string('training_course');             // Leadership Development Program
            $table->string('training_topic');              // Strategic Leadership
            $table->string('provider_type');               // Internal / External
            $table->string('provider');                    // Dharma Learning Center
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time')->default('09:00:00');
            $table->time('end_time')->default('17:00:00');
            $table->string('status')->default('Open Registration'); // Open Registration, Sedang Berlangsung, Selesai
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_trainings');
    }
};

