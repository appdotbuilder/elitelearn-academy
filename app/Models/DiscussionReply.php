<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\DiscussionReply
 *
 * @property int $id
 * @property int $discussion_id
 * @property int $user_id
 * @property int|null $parent_id
 * @property string $content
 * @property int $likes_count
 * @property bool $is_solution
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Discussion $discussion
 * @property-read \App\Models\User $user
 * @property-read \App\Models\DiscussionReply|null $parent
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionReply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionReply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionReply query()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionReply solutions()

 * 
 * @mixin \Eloquent
 */
class DiscussionReply extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'discussion_id',
        'user_id',
        'parent_id',
        'content',
        'likes_count',
        'is_solution',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'likes_count' => 'integer',
        'is_solution' => 'boolean',
    ];

    /**
     * Get the discussion that owns the reply.
     */
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    /**
     * Get the user that created the reply.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent reply.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(DiscussionReply::class, 'parent_id');
    }

    /**
     * Scope a query to only include solution replies.
     */
    public function scopeSolutions($query)
    {
        return $query->where('is_solution', true);
    }
}