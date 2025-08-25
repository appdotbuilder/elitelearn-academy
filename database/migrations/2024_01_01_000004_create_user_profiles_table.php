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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('country')->nullable();
            $table->string('timezone')->default('UTC');
            $table->string('language')->default('en');
            $table->json('social_links')->nullable();
            $table->string('occupation')->nullable();
            $table->enum('experience_level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->json('interests')->nullable();
            $table->integer('points')->default(0);
            $table->integer('total_courses_completed')->default(0);
            $table->integer('total_hours_learned')->default(0);
            $table->timestamps();
            
            $table->index(['user_id']);
            $table->index(['points']);
            $table->index(['experience_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};