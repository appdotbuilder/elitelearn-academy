<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        $featuredCourses = Course::published()
            ->featured()
            ->with(['instructor', 'category'])
            ->take(6)
            ->get();

        $popularCourses = Course::published()
            ->with(['instructor', 'category'])
            ->orderBy('total_students', 'desc')
            ->orderBy('average_rating', 'desc')
            ->take(8)
            ->get();

        $categories = Category::active()
            ->withCount(['courses' => function ($query) {
                $query->published();
            }])
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $stats = [
            'total_courses' => Course::published()->count(),
            'total_students' => User::whereHas('roles', function ($query) {
                $query->where('name', 'student');
            })->count(),
            'total_instructors' => User::whereHas('roles', function ($query) {
                $query->where('name', 'instructor');
            })->count(),
            'total_hours' => Course::published()->sum('duration_minutes') / 60,
        ];

        return Inertia::render('welcome', [
            'featuredCourses' => $featuredCourses,
            'popularCourses' => $popularCourses,
            'categories' => $categories,
            'stats' => $stats,
        ]);
    }
}