<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserBadge
 *
 * @property int $id
 * @property int $user_id
 * @property int $badge_id
 * @property \Illuminate\Support\Carbon $earned_at
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Badge $badge
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereBadgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereEarnedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBadge whereUserId($value)

 * 
 * @mixin \Eloquent
 */
class UserBadge extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'badge_id',
        'earned_at',
        'reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'earned_at' => 'datetime',
    ];

    /**
     * Get the user that earned the badge.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the badge that was earned.
     */
    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }
}