import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface Instructor {
    id: number;
    name: string;
    profile?: {
        bio?: string;
        avatar?: string;
        occupation?: string;
    };
}

interface Category {
    id: number;
    name: string;
    color: string;
}

interface Lesson {
    id: number;
    title: string;
    type: string;
    duration_minutes: number;
    is_free: boolean;
}

interface Section {
    id: number;
    title: string;
    lessons: Lesson[];
}

interface Rating {
    id: number;
    rating: number;
    review: string;
    user: {
        name: string;
    };
    created_at: string;
}

interface Course {
    id: number;
    title: string;
    short_description: string;
    description: string;
    thumbnail?: string;
    preview_video?: string;
    instructor: Instructor;
    category: Category;
    level: string;
    price: number;
    is_free: boolean;
    requirements?: string[];
    what_you_will_learn?: string[];
    tags?: string[];
    language: string;
    duration_minutes: number;
    total_lessons: number;
    total_students: number;
    average_rating: number;
    total_ratings: number;
    sections: Section[];
    ratings: Rating[];
}

interface Enrollment {
    id: number;
    progress_percentage: number;
}

interface Props {
    course: Course;
    isEnrolled: boolean;
    enrollment?: Enrollment;
    similarCourses: Course[];
    [key: string]: unknown;
}

export default function CourseShow({ course, isEnrolled, enrollment, similarCourses = [] }: Props) {
    const handleEnroll = () => {
        router.post(`/courses/${course.id}/enroll`, {}, {
            preserveState: true,
        });
    };

    const formatPrice = (price: number, is_free: boolean) => {
        if (is_free) return 'Free';
        return `$${price.toFixed(2)}`;
    };

    const formatDuration = (minutes: number) => {
        const hours = Math.floor(minutes / 60);
        const mins = minutes % 60;
        if (hours > 0) {
            return `${hours}h ${mins > 0 ? `${mins}m` : ''}`.trim();
        }
        return `${mins}m`;
    };

    const formatNumber = (num: number) => {
        if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    };

    const renderStars = (rating: number) => {
        return Array.from({ length: 5 }, (_, i) => (
            <span key={i} className={i < rating ? 'text-yellow-500' : 'text-slate-300'}>
                ★
            </span>
        ));
    };

    return (
        <AppShell>
            <Head title={`${course.title} - EliteLearn Academy`} />
            
            <div className="space-y-8">
                {/* Course Header */}
                <div className="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-8 text-white">
                    <div className="grid lg:grid-cols-3 gap-8">
                        <div className="lg:col-span-2 space-y-6">
                            <div>
                                <div className="flex items-center gap-3 mb-4">
                                    <span 
                                        className="px-3 py-1 rounded-lg text-sm font-medium text-white"
                                        style={{ backgroundColor: course.category.color }}
                                    >
                                        {course.category.name}
                                    </span>
                                    <span className="px-3 py-1 rounded-lg text-sm font-medium bg-white/20 text-white capitalize">
                                        {course.level}
                                    </span>
                                </div>
                                <h1 className="text-4xl lg:text-5xl font-bold mb-4">
                                    {course.title}
                                </h1>
                                <p className="text-xl opacity-90">
                                    {course.short_description}
                                </p>
                            </div>

                            <div className="flex flex-wrap items-center gap-6 text-sm opacity-90">
                                <div className="flex items-center gap-2">
                                    <span>👨‍🏫</span>
                                    <span>{course.instructor.name}</span>
                                </div>
                                <div className="flex items-center gap-2">
                                    <span>⭐</span>
                                    <span>{course.average_rating.toFixed(1)} ({formatNumber(course.total_ratings)} ratings)</span>
                                </div>
                                <div className="flex items-center gap-2">
                                    <span>👥</span>
                                    <span>{formatNumber(course.total_students)} students</span>
                                </div>
                                <div className="flex items-center gap-2">
                                    <span>🕐</span>
                                    <span>{formatDuration(course.duration_minutes)}</span>
                                </div>
                                <div className="flex items-center gap-2">
                                    <span>📚</span>
                                    <span>{course.total_lessons} lessons</span>
                                </div>
                            </div>
                        </div>

                        <div className="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                            <div className="aspect-video bg-white/20 rounded-lg mb-4 flex items-center justify-center">
                                <div className="text-6xl">🎥</div>
                            </div>
                            
                            <div className="text-center mb-6">
                                <div className="text-3xl font-bold mb-2">
                                    {formatPrice(course.price, course.is_free)}
                                </div>
                                {!course.is_free && (
                                    <div className="text-sm opacity-70">
                                        💳 One-time payment
                                    </div>
                                )}
                            </div>

                            {isEnrolled ? (
                                <div className="space-y-4">
                                    <div className="bg-green-500/20 text-green-100 p-4 rounded-lg text-center">
                                        ✅ You're enrolled in this course
                                    </div>
                                    {enrollment && (
                                        <div>
                                            <div className="text-sm mb-2">Progress: {enrollment.progress_percentage.toFixed(0)}%</div>
                                            <div className="bg-white/20 rounded-full h-2">
                                                <div 
                                                    className="bg-green-500 h-2 rounded-full transition-all"
                                                    style={{ width: `${enrollment.progress_percentage}%` }}
                                                />
                                            </div>
                                        </div>
                                    )}
                                    <Link
                                        href={`/learn/${course.id}`}
                                        className="block w-full bg-green-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-green-700 transition-all"
                                    >
                                        🎯 Continue Learning
                                    </Link>
                                </div>
                            ) : (
                                <button
                                    onClick={handleEnroll}
                                    className="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all"
                                >
                                    {course.is_free ? '🚀 Enroll for Free' : '💳 Enroll Now'}
                                </button>
                            )}
                        </div>
                    </div>
                </div>

                <div className="grid lg:grid-cols-3 gap-8">
                    {/* Main Content */}
                    <div className="lg:col-span-2 space-y-8">
                        {/* About this course */}
                        <div className="bg-white rounded-xl p-6 shadow-lg border border-slate-200">
                            <h2 className="text-2xl font-bold text-slate-800 mb-4">
                                📖 About this course
                            </h2>
                            <div 
                                className="prose prose-slate max-w-none"
                                dangerouslySetInnerHTML={{ __html: course.description.replace(/\n/g, '<br>') }}
                            />
                        </div>

                        {/* What you'll learn */}
                        {course.what_you_will_learn && course.what_you_will_learn.length > 0 && (
                            <div className="bg-white rounded-xl p-6 shadow-lg border border-slate-200">
                                <h2 className="text-2xl font-bold text-slate-800 mb-4">
                                    🎯 What you'll learn
                                </h2>
                                <div className="grid md:grid-cols-2 gap-3">
                                    {course.what_you_will_learn.map((item, index) => (
                                        <div key={index} className="flex items-start gap-3">
                                            <span className="text-green-500 mt-1">✓</span>
                                            <span className="text-slate-700">{item}</span>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}

                        {/* Course Content */}
                        <div className="bg-white rounded-xl p-6 shadow-lg border border-slate-200">
                            <h2 className="text-2xl font-bold text-slate-800 mb-4">
                                📋 Course Content
                            </h2>
                            <div className="space-y-4">
                                {course.sections.map((section) => (
                                    <div key={section.id} className="border border-slate-200 rounded-lg">
                                        <div className="p-4 bg-slate-50">
                                            <h3 className="font-semibold text-slate-800">
                                                {section.title}
                                            </h3>
                                            <div className="text-sm text-slate-600">
                                                {section.lessons.length} lessons
                                            </div>
                                        </div>
                                        <div className="p-4 space-y-2">
                                            {section.lessons.map((lesson) => (
                                                <div key={lesson.id} className="flex items-center justify-between py-2">
                                                    <div className="flex items-center gap-3">
                                                        <span className="text-slate-400">
                                                            {lesson.type === 'video' ? '🎥' : 
                                                             lesson.type === 'quiz' ? '❓' : '📄'}
                                                        </span>
                                                        <span className="text-slate-700">
                                                            {lesson.title}
                                                        </span>
                                                        {lesson.is_free && (
                                                            <span className="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
                                                                Free
                                                            </span>
                                                        )}
                                                    </div>
                                                    <div className="text-sm text-slate-500">
                                                        {formatDuration(lesson.duration_minutes)}
                                                    </div>
                                                </div>
                                            ))}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>

                        {/* Reviews */}
                        {course.ratings.length > 0 && (
                            <div className="bg-white rounded-xl p-6 shadow-lg border border-slate-200">
                                <h2 className="text-2xl font-bold text-slate-800 mb-4">
                                    ⭐ Student Reviews
                                </h2>
                                <div className="space-y-6">
                                    {course.ratings.map((rating) => (
                                        <div key={rating.id} className="border-b border-slate-200 last:border-b-0 pb-6 last:pb-0">
                                            <div className="flex items-center gap-4 mb-3">
                                                <div className="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                                    {rating.user.name.charAt(0)}
                                                </div>
                                                <div>
                                                    <div className="font-semibold text-slate-800">
                                                        {rating.user.name}
                                                    </div>
                                                    <div className="flex items-center gap-2">
                                                        <div className="flex">
                                                            {renderStars(rating.rating)}
                                                        </div>
                                                        <span className="text-sm text-slate-500">
                                                            {new Date(rating.created_at).toLocaleDateString()}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p className="text-slate-700">
                                                {rating.review}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Instructor */}
                        <div className="bg-white rounded-xl p-6 shadow-lg border border-slate-200">
                            <h3 className="text-xl font-bold text-slate-800 mb-4">
                                👨‍🏫 Instructor
                            </h3>
                            <div className="flex items-start gap-4">
                                <div className="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                    {course.instructor.name.charAt(0)}
                                </div>
                                <div>
                                    <h4 className="font-semibold text-slate-800 mb-1">
                                        {course.instructor.name}
                                    </h4>
                                    {course.instructor.profile?.occupation && (
                                        <div className="text-slate-600 text-sm mb-2">
                                            {course.instructor.profile.occupation}
                                        </div>
                                    )}
                                    {course.instructor.profile?.bio && (
                                        <p className="text-slate-600 text-sm">
                                            {course.instructor.profile.bio}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>

                        {/* Requirements */}
                        {course.requirements && course.requirements.length > 0 && (
                            <div className="bg-white rounded-xl p-6 shadow-lg border border-slate-200">
                                <h3 className="text-xl font-bold text-slate-800 mb-4">
                                    ✅ Requirements
                                </h3>
                                <ul className="space-y-2">
                                    {course.requirements.map((requirement, index) => (
                                        <li key={index} className="flex items-start gap-3">
                                            <span className="text-blue-500 mt-1">•</span>
                                            <span className="text-slate-700 text-sm">{requirement}</span>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        )}

                        {/* Tags */}
                        {course.tags && course.tags.length > 0 && (
                            <div className="bg-white rounded-xl p-6 shadow-lg border border-slate-200">
                                <h3 className="text-xl font-bold text-slate-800 mb-4">
                                    🏷️ Tags
                                </h3>
                                <div className="flex flex-wrap gap-2">
                                    {course.tags.map((tag, index) => (
                                        <span 
                                            key={index}
                                            className="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-sm"
                                        >
                                            {tag}
                                        </span>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>
                </div>

                {/* Similar Courses */}
                {similarCourses.length > 0 && (
                    <div className="bg-white rounded-xl p-6 shadow-lg border border-slate-200">
                        <h2 className="text-2xl font-bold text-slate-800 mb-6">
                            💡 You might also like
                        </h2>
                        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                            {similarCourses.map((similarCourse) => (
                                <Link
                                    key={similarCourse.id}
                                    href={`/courses/${similarCourse.id}`}
                                    className="group"
                                >
                                    <div className="aspect-video bg-gradient-to-r from-slate-200 to-slate-300 rounded-lg mb-3 flex items-center justify-center group-hover:from-blue-100 group-hover:to-purple-100 transition-all">
                                        <span className="text-3xl group-hover:scale-110 transition-transform">🎓</span>
                                    </div>
                                    <h4 className="font-semibold text-slate-800 mb-1 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                        {similarCourse.title}
                                    </h4>
                                    <div className="text-sm text-slate-600 mb-2">
                                        {similarCourse.instructor.name}
                                    </div>
                                    <div className="flex items-center justify-between">
                                        <div className="flex items-center gap-1">
                                            <span className="text-yellow-500 text-sm">⭐</span>
                                            <span className="text-sm">{similarCourse.average_rating.toFixed(1)}</span>
                                        </div>
                                        <div className="font-semibold text-blue-600">
                                            {formatPrice(similarCourse.price, similarCourse.is_free)}
                                        </div>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </AppShell>
    );
}