<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LessonProgress
 *
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property int $lesson_id
 * @property bool $is_completed
 * @property int $watch_time_seconds
 * @property int $total_duration_seconds
 * @property float $completion_percentage
 * @property array|null $quiz_answers
 * @property float|null $quiz_score
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $last_accessed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\Lesson $lesson
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProgress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProgress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProgress query()
 * @method static \Illuminate\Database\Eloquent\Builder|LessonProgress completed()

 * 
 * @mixin \Eloquent
 */
class LessonProgress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'lesson_id',
        'is_completed',
        'watch_time_seconds',
        'total_duration_seconds',
        'completion_percentage',
        'quiz_answers',
        'quiz_score',
        'notes',
        'started_at',
        'completed_at',
        'last_accessed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_completed' => 'boolean',
        'watch_time_seconds' => 'integer',
        'total_duration_seconds' => 'integer',
        'completion_percentage' => 'decimal:2',
        'quiz_answers' => 'array',
        'quiz_score' => 'decimal:2',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_accessed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the progress.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course for the progress.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lesson for the progress.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Scope a query to only include completed progress.
     */
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }
}