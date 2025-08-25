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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description');
            $table->string('thumbnail')->nullable();
            $table->string('preview_video')->nullable();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'archived'])->default('draft');
            $table->decimal('price', 8, 2)->default(0.00);
            $table->boolean('is_free')->default(true);
            $table->json('requirements')->nullable();
            $table->json('what_you_will_learn')->nullable();
            $table->json('tags')->nullable();
            $table->string('language')->default('en');
            $table->integer('duration_minutes')->default(0);
            $table->integer('total_lessons')->default(0);
            $table->integer('total_students')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('total_ratings')->default(0);
            $table->datetime('published_at')->nullable();
            $table->datetime('featured_until')->nullable();
            $table->timestamps();
            
            $table->index(['instructor_id']);
            $table->index(['category_id']);
            $table->index(['status', 'published_at']);
            $table->index(['is_free', 'status']);
            $table->index(['level', 'status']);
            $table->index(['average_rating', 'total_ratings']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};