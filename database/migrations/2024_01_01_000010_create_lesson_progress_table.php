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
        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->integer('watch_time_seconds')->default(0);
            $table->integer('total_duration_seconds')->default(0);
            $table->decimal('completion_percentage', 5, 2)->default(0.00);
            $table->json('quiz_answers')->nullable();
            $table->decimal('quiz_score', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->datetime('last_accessed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'lesson_id']);
            $table->index(['user_id', 'course_id']);
            $table->index(['lesson_id', 'is_completed']);
            $table->index(['course_id', 'is_completed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_progress');
    }
};