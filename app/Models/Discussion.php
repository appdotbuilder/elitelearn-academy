<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Discussion
 *
 * @property int $id
 * @property int $course_id
 * @property int|null $lesson_id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property bool $is_pinned
 * @property bool $is_resolved
 * @property int $replies_count
 * @property int $likes_count
 * @property \Illuminate\Support\Carbon|null $last_activity_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\Lesson|null $lesson
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DiscussionReply[] $replies
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Discussion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discussion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discussion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Discussion pinned()
 * @method static \Illuminate\Database\Eloquent\Builder|Discussion resolved()

 * 
 * @mixin \Eloquent
 */
class Discussion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'lesson_id',
        'user_id',
        'title',
        'content',
        'is_pinned',
        'is_resolved',
        'replies_count',
        'likes_count',
        'last_activity_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_pinned' => 'boolean',
        'is_resolved' => 'boolean',
        'replies_count' => 'integer',
        'likes_count' => 'integer',
        'last_activity_at' => 'datetime',
    ];

    /**
     * Get the course that owns the discussion.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lesson that the discussion belongs to.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the user that created the discussion.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the replies for the discussion.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(DiscussionReply::class);
    }

    /**
     * Scope a query to only include pinned discussions.
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope a query to only include resolved discussions.
     */
    public function scopeResolved($query)
    {
        return $query->where('is_resolved', true);
    }
}