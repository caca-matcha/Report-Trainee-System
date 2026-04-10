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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->date('start_date');
            $table->string('training_type')->default('In House Training');
            $table->string('status')->default('draft'); // draft, post_training, pending_approval, approved, rejected
            $table->timestamps();
        });

        Schema::create('training_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained('trainings')->onDelete('cascade');
            $table->string('name');
            $table->string('npk')->nullable();
            $table->string('department')->nullable();
            $table->string('subco')->nullable();
            $table->string('photo_path')->nullable();
            $table->decimal('pre_test_score', 5, 2)->nullable();
            $table->decimal('post_test_score', 5, 2)->nullable();
            $table->decimal('observation_score', 5, 2)->nullable();
            $table->decimal('negotiation_score', 5, 2)->nullable();
            $table->boolean('is_present')->default(false);
            $table->timestamps();
        });

        Schema::create('training_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained('trainings')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // Approver
            $table->integer('level'); // 1=PIC, 2=SCH, 3=DPH, 4=Deputy
            $table->string('status'); // approved, rejected
            $table->text('note')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('training_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained('trainings')->onDelete('cascade');
            $table->text('presence_summary')->nullable(); // JSON or Text
            $table->string('pass_statement')->nullable();
            $table->decimal('average_score', 5, 2)->nullable();
            $table->string('presence_ratio')->nullable();
            $table->text('comment')->nullable();
            $table->text('additional_field_1')->nullable();
            $table->text('additional_field_2')->nullable();
            $table->text('recommendation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_summaries');
        Schema::dropIfExists('training_approvals');
        Schema::dropIfExists('training_participants');
        Schema::dropIfExists('trainings');
    }
};
