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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->decimal('price_paid', 8, 2)->default(0.00);
            $table->enum('status', ['active', 'completed', 'cancelled', 'expired'])->default('active');
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->integer('completed_lessons')->default(0);
            $table->integer('total_lessons')->default(0);
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->datetime('expires_at')->nullable();
            $table->datetime('last_accessed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'course_id']);
            $table->index(['user_id', 'status']);
            $table->index(['course_id', 'status']);
            $table->index(['status', 'progress_percentage']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};