<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\CourseSection
 *
 * @property int $id
 * @property int $course_id
 * @property string $title
 * @property string|null $description
 * @property int $sort_order
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lesson[] $lessons
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection query()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection published()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseSection whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class CourseSection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'sort_order',
        'is_published',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the course that owns the section.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lessons for the section.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'section_id')->orderBy('sort_order');
    }

    /**
     * Scope a query to only include published sections.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}