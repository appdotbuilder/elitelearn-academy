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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained('course_sections')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->enum('type', ['video', 'text', 'quiz', 'assignment', 'download'])->default('video');
            $table->text('content')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_duration')->nullable();
            $table->json('attachments')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_free')->default(false);
            $table->integer('duration_minutes')->default(0);
            $table->json('quiz_data')->nullable();
            $table->timestamps();
            
            $table->index(['course_id', 'section_id']);
            $table->index(['course_id', 'sort_order']);
            $table->index(['section_id', 'sort_order']);
            $table->index(['type', 'is_published']);
            $table->unique(['course_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};