<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserProfile
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $avatar
 * @property string|null $bio
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property string|null $country
 * @property string $timezone
 * @property string $language
 * @property array|null $social_links
 * @property string|null $occupation
 * @property string $experience_level
 * @property array|null $interests
 * @property int $points
 * @property int $total_courses_completed
 * @property int $total_hours_learned
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereExperienceLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereInterests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereSocialLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereTotalCoursesCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereTotalHoursLearned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserProfile whereUserId($value)

 * 
 * @mixin \Eloquent
 */
class UserProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'avatar',
        'bio',
        'phone',
        'date_of_birth',
        'country',
        'timezone',
        'language',
        'social_links',
        'occupation',
        'experience_level',
        'interests',
        'points',
        'total_courses_completed',
        'total_hours_learned',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'social_links' => 'array',
        'interests' => 'array',
        'points' => 'integer',
        'total_courses_completed' => 'integer',
        'total_hours_learned' => 'integer',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}