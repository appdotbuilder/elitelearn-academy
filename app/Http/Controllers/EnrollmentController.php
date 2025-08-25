<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Enroll the authenticated user in the course.
     */
    public function store(Request $request, Course $course)
    {
        $user = Auth::user();

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You are already enrolled in this course.');
        }

        // For free courses, enroll immediately
        if ($course->is_free) {
            Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'price_paid' => 0,
                'status' => 'active',
                'total_lessons' => $course->total_lessons,
                'started_at' => now(),
            ]);

            // Update course student count
            $course->increment('total_students');

            return redirect()->route('learn.course', $course)
                ->with('success', 'Successfully enrolled in the course!');
        }

        // For paid courses, redirect to payment (simulated)
        return redirect()->route('courses.show', $course)
            ->with('info', 'Payment integration would be handled here for paid courses.');
    }
}