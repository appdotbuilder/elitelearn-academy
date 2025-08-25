<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Enrollment
 *
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property float $price_paid
 * @property string $status
 * @property float $progress_percentage
 * @property int $completed_lessons
 * @property int $total_lessons
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $last_accessed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Course $course
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment active()
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment completed()
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereCompletedLessons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereLastAccessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment wherePricePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereProgressPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereTotalLessons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Enrollment whereUserId($value)

 * 
 * @mixin \Eloquent
 */
class Enrollment extends Model
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
        'price_paid',
        'status',
        'progress_percentage',
        'completed_lessons',
        'total_lessons',
        'started_at',
        'completed_at',
        'expires_at',
        'last_accessed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_paid' => 'decimal:2',
        'progress_percentage' => 'decimal:2',
        'completed_lessons' => 'integer',
        'total_lessons' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_accessed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the enrollment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course for the enrollment.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope a query to only include active enrollments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include completed enrollments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}