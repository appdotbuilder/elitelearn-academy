<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     */
    public function index(Request $request)
    {
        $query = Course::published()
            ->with(['instructor', 'category']);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('short_description', 'like', "%{$searchTerm}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->get('category'));
        }

        // Level filter
        if ($request->filled('level')) {
            $query->where('level', $request->get('level'));
        }

        // Price filter
        if ($request->filled('price_type')) {
            $priceType = $request->get('price_type');
            if ($priceType === 'free') {
                $query->where('is_free', true);
            } elseif ($priceType === 'paid') {
                $query->where('is_free', false);
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'popular');
        switch ($sortBy) {
            case 'newest':
                $query->orderBy('published_at', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default: // popular
                $query->orderBy('total_students', 'desc')
                      ->orderBy('average_rating', 'desc');
        }

        $courses = $query->paginate(12);
        $categories = Category::active()
            ->withCount(['courses' => function ($query) {
                $query->published();
            }])
            ->orderBy('name')
            ->get();

        return Inertia::render('courses/index', [
            'courses' => $courses,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'level', 'price_type', 'sort']),
        ]);
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {

        $categories = Category::active()->orderBy('name')->get();

        return Inertia::render('courses/create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();
        $data['instructor_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title']);

        $course = Course::create($data);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course created successfully. It will be reviewed before publication.');
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $course->load([
            'instructor.profile',
            'category',
            'sections.lessons' => function ($query) {
                $query->published()->orderBy('sort_order');
            },
            'ratings' => function ($query) {
                $query->where('is_published', true)
                      ->with('user')
                      ->latest()
                      ->take(10);
            }
        ]);

        $isEnrolled = false;
        $enrollment = null;
        
        if (Auth::check()) {
            $enrollment = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->first();
            $isEnrolled = $enrollment !== null;
        }

        $similarCourses = Course::published()
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->with(['instructor', 'category'])
            ->take(4)
            ->get();

        return Inertia::render('courses/show', [
            'course' => $course,
            'isEnrolled' => $isEnrolled,
            'enrollment' => $enrollment,
            'similarCourses' => $similarCourses,
        ]);
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {

        $categories = Category::active()->orderBy('name')->get();

        return Inertia::render('courses/edit', [
            'course' => $course,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified course in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);

        $course->update($data);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }


}