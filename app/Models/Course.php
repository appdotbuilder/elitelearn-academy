<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Course
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $short_description
 * @property string|null $thumbnail
 * @property string|null $preview_video
 * @property int $instructor_id
 * @property int $category_id
 * @property string $level
 * @property string $status
 * @property float $price
 * @property bool $is_free
 * @property array|null $requirements
 * @property array|null $what_you_will_learn
 * @property array|null $tags
 * @property string $language
 * @property int $duration_minutes
 * @property int $total_lessons
 * @property int $total_students
 * @property float $average_rating
 * @property int $total_ratings
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $featured_until
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $instructor
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CourseSection[] $sections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lesson[] $lessons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Enrollment[] $enrollments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CourseRating[] $ratings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Discussion[] $discussions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Certificate[] $certificates
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|Course published()
 * @method static \Illuminate\Database\Eloquent\Builder|Course featured()
 * @method static \Illuminate\Database\Eloquent\Builder|Course free()
 * @method static \Illuminate\Database\Eloquent\Builder|Course paid()
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereAverageRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereDurationMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereFeaturedUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereInstructorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereIsFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course wherePreviewVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereTotalLessons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereTotalRatings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereTotalStudents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereWhatYouWillLearn($value)

 * 
 * @mixin \Eloquent
 */
class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'thumbnail',
        'preview_video',
        'instructor_id',
        'category_id',
        'level',
        'status',
        'price',
        'is_free',
        'requirements',
        'what_you_will_learn',
        'tags',
        'language',
        'duration_minutes',
        'total_lessons',
        'published_at',
        'featured_until',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_free' => 'boolean',
        'requirements' => 'array',
        'what_you_will_learn' => 'array',
        'tags' => 'array',
        'duration_minutes' => 'integer',
        'total_lessons' => 'integer',
        'total_students' => 'integer',
        'average_rating' => 'decimal:2',
        'total_ratings' => 'integer',
        'published_at' => 'datetime',
        'featured_until' => 'datetime',
    ];

    /**
     * Get the instructor that teaches the course.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the category that the course belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the sections of the course.
     */
    public function sections(): HasMany
    {
        return $this->hasMany(CourseSection::class)->orderBy('sort_order');
    }

    /**
     * Get the lessons of the course.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }

    /**
     * Get the enrollments for the course.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the ratings for the course.
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(CourseRating::class);
    }

    /**
     * Get the discussions for the course.
     */
    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }

    /**
     * Get the certificates for the course.
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Scope a query to only include published courses.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'approved')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include featured courses.
     */
    public function scopeFeatured($query)
    {
        return $query->whereNotNull('featured_until')
                    ->where('featured_until', '>', now());
    }

    /**
     * Scope a query to only include free courses.
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    /**
     * Scope a query to only include paid courses.
     */
    public function scopePaid($query)
    {
        return $query->where('is_free', false);
    }
}