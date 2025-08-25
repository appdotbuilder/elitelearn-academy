<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CourseRating
 *
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property int $rating
 * @property string|null $review
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Course $course
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating query()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating published()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating whereReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseRating whereUserId($value)

 * 
 * @mixin \Eloquent
 */
class CourseRating extends Model
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
        'rating',
        'review',
        'is_published',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'is_published' => 'boolean',
    ];

    /**
     * Get the user that owns the rating.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that was rated.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope a query to only include published ratings.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}