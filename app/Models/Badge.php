<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Badge
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $icon
 * @property string $color
 * @property string $type
 * @property array|null $criteria
 * @property int $points_reward
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserBadge[] $userBadges
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Badge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Badge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Badge query()
 * @method static \Illuminate\Database\Eloquent\Builder|Badge active()
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereCriteria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge wherePointsReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class Badge extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'type',
        'criteria',
        'points_reward',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'criteria' => 'array',
        'points_reward' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user badges.
     */
    public function userBadges(): HasMany
    {
        return $this->hasMany(UserBadge::class);
    }

    /**
     * Scope a query to only include active badges.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}