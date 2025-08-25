<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Lesson
 *
 * @property int $id
 * @property int $course_id
 * @property int $section_id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string $type
 * @property string|null $content
 * @property string|null $video_url
 * @property string|null $video_duration
 * @property array|null $attachments
 * @property int $sort_order
 * @property bool $is_published
 * @property bool $is_free
 * @property int $duration_minutes
 * @property array|null $quiz_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\CourseSection $section
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LessonProgress[] $progress
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Discussion[] $discussions
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson published()
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson free()
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereDurationMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereIsFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereQuizData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereVideoDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereVideoUrl($value)

 * 
 * @mixin \Eloquent
 */
class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'section_id',
        'title',
        'slug',
        'description',
        'type',
        'content',
        'video_url',
        'video_duration',
        'attachments',
        'sort_order',
        'is_published',
        'is_free',
        'duration_minutes',
        'quiz_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attachments' => 'array',
        'sort_order' => 'integer',
        'is_published' => 'boolean',
        'is_free' => 'boolean',
        'duration_minutes' => 'integer',
        'quiz_data' => 'array',
    ];

    /**
     * Get the course that owns the lesson.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the section that owns the lesson.
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(CourseSection::class, 'section_id');
    }

    /**
     * Get the progress records for the lesson.
     */
    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    /**
     * Get the discussions for the lesson.
     */
    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }

    /**
     * Scope a query to only include published lessons.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to only include free lessons.
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }
}