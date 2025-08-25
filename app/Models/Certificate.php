<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Certificate
 *
 * @property int $id
 * @property string $certificate_number
 * @property int $user_id
 * @property int $course_id
 * @property string $student_name
 * @property string $course_title
 * @property string $instructor_name
 * @property \Illuminate\Support\Carbon $completion_date
 * @property \Illuminate\Support\Carbon $issued_date
 * @property string $verification_url
 * @property string|null $certificate_url
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Course $course
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereCertificateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereCertificateUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereCompletionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereCourseTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereInstructorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereIssuedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereStudentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Certificate whereVerificationUrl($value)

 * 
 * @mixin \Eloquent
 */
class Certificate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'certificate_number',
        'user_id',
        'course_id',
        'student_name',
        'course_title',
        'instructor_name',
        'completion_date',
        'issued_date',
        'verification_url',
        'certificate_url',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completion_date' => 'datetime',
        'issued_date' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user that earned the certificate.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course for which the certificate was earned.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}