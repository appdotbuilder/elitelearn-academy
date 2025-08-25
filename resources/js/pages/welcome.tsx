import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import { type SharedData } from '@/types';

interface Course {
    id: number;
    title: string;
    short_description: string;
    thumbnail?: string;
    instructor: {
        name: string;
    };
    category: {
        name: string;
        color: string;
    };
    price: number;
    is_free: boolean;
    average_rating: number;
    total_students: number;
    level: string;
}

interface Category {
    id: number;
    name: string;
    color: string;
    icon?: string;
    courses_count: number;
}

interface Stats {
    total_courses: number;
    total_students: number;
    total_instructors: number;
    total_hours: number;
}

interface Props {
    featuredCourses: Course[];
    popularCourses: Course[];
    categories: Category[];
    stats: Stats;
    [key: string]: unknown;
}

export default function Welcome({ featuredCourses = [], categories = [], stats }: Props) {
    const { auth } = usePage<SharedData>().props;

    const formatPrice = (price: number, is_free: boolean) => {
        if (is_free) return 'Free';
        return `$${price.toFixed(2)}`;
    };

    const formatNumber = (num: number) => {
        if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    };

    return (
        <>
            <Head title="EliteLearn Academy - Advanced Online Learning Platform">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
            </Head>
            
            <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
                {/* Navigation */}
                <header className="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center space-x-2">
                                <div className="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                                    <span className="text-white font-bold text-sm">EL</span>
                                </div>
                                <h1 className="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    EliteLearn Academy
                                </h1>
                            </div>
                            
                            <nav className="flex items-center space-x-4">
                                <Link href="/courses" className="text-slate-600 hover:text-slate-900 font-medium">
                                    Courses
                                </Link>
                                {auth.user ? (
                                    <div className="flex items-center space-x-3">
                                        <Link
                                            href={route('dashboard')}
                                            className="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all"
                                        >
                                            Dashboard
                                        </Link>
                                    </div>
                                ) : (
                                    <div className="flex items-center space-x-3">
                                        <Link
                                            href={route('login')}
                                            className="text-slate-600 hover:text-slate-900 font-medium"
                                        >
                                            Log in
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all"
                                        >
                                            Get Started
                                        </Link>
                                    </div>
                                )}
                            </nav>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <section className="py-20 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto text-center">
                        <div className="mb-8">
                            <h2 className="text-5xl lg:text-6xl font-bold mb-6">
                                <span className="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                                    🎓 Master New Skills
                                </span>
                                <br />
                                <span className="text-slate-800">
                                    with Elite Education
                                </span>
                            </h2>
                            <p className="text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
                                Join thousands of learners on EliteLearn Academy, where world-class instructors 
                                meet cutting-edge technology to deliver an unparalleled learning experience.
                            </p>
                        </div>

                        <div className="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                            {!auth.user && (
                                <>
                                    <Link
                                        href={route('register')}
                                        className="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all shadow-lg"
                                    >
                                        🚀 Start Learning Today
                                    </Link>
                                    <Link
                                        href="/courses"
                                        className="bg-white text-slate-700 px-8 py-4 rounded-xl font-semibold text-lg border-2 border-slate-200 hover:border-slate-300 hover:shadow-lg transition-all"
                                    >
                                        📚 Browse Courses
                                    </Link>
                                </>
                            )}
                            {auth.user && (
                                <Link
                                    href="/courses"
                                    className="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all shadow-lg"
                                >
                                    🔍 Explore Courses
                                </Link>
                            )}
                        </div>

                        {/* Stats */}
                        <div className="grid grid-cols-2 lg:grid-cols-4 gap-8 bg-white/60 backdrop-blur-sm rounded-2xl p-8 border border-slate-200">
                            <div className="text-center">
                                <div className="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    {formatNumber(stats?.total_courses || 0)}
                                </div>
                                <div className="text-slate-600 font-medium">Expert Courses</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                    {formatNumber(stats?.total_students || 0)}+
                                </div>
                                <div className="text-slate-600 font-medium">Active Learners</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                                    {formatNumber(stats?.total_instructors || 0)}
                                </div>
                                <div className="text-slate-600 font-medium">World-Class Instructors</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                                    {Math.round(stats?.total_hours || 0)}
                                </div>
                                <div className="text-slate-600 font-medium">Hours of Content</div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Key Features */}
                <section className="py-16 px-4 sm:px-6 lg:px-8 bg-white/50">
                    <div className="max-w-7xl mx-auto">
                        <div className="text-center mb-16">
                            <h3 className="text-4xl font-bold text-slate-800 mb-4">
                                🌟 Why Choose EliteLearn Academy?
                            </h3>
                            <p className="text-xl text-slate-600 max-w-3xl mx-auto">
                                Experience next-generation online learning with features designed for success
                            </p>
                        </div>

                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div className="bg-white rounded-2xl p-8 shadow-lg border border-slate-200 hover:shadow-xl transition-all">
                                <div className="text-4xl mb-4">🤖</div>
                                <h4 className="text-xl font-semibold text-slate-800 mb-3">AI-Powered Recommendations</h4>
                                <p className="text-slate-600">Get personalized course suggestions based on your learning history and career goals.</p>
                            </div>
                            
                            <div className="bg-white rounded-2xl p-8 shadow-lg border border-slate-200 hover:shadow-xl transition-all">
                                <div className="text-4xl mb-4">🎮</div>
                                <h4 className="text-xl font-semibold text-slate-800 mb-3">Gamification & Badges</h4>
                                <p className="text-slate-600">Earn points, unlock achievements, and compete on leaderboards while you learn.</p>
                            </div>
                            
                            <div className="bg-white rounded-2xl p-8 shadow-lg border border-slate-200 hover:shadow-xl transition-all">
                                <div className="text-4xl mb-4">💬</div>
                                <h4 className="text-xl font-semibold text-slate-800 mb-3">Real-time Collaboration</h4>
                                <p className="text-slate-600">Join live discussions, participate in forums, and connect with fellow learners.</p>
                            </div>
                            
                            <div className="bg-white rounded-2xl p-8 shadow-lg border border-slate-200 hover:shadow-xl transition-all">
                                <div className="text-4xl mb-4">🎯</div>
                                <h4 className="text-xl font-semibold text-slate-800 mb-3">Interactive Assessments</h4>
                                <p className="text-slate-600">Test your knowledge with auto-graded quizzes and practical assignments.</p>
                            </div>
                            
                            <div className="bg-white rounded-2xl p-8 shadow-lg border border-slate-200 hover:shadow-xl transition-all">
                                <div className="text-4xl mb-4">🏆</div>
                                <h4 className="text-xl font-semibold text-slate-800 mb-3">Verifiable Certificates</h4>
                                <p className="text-slate-600">Earn industry-recognized certificates to boost your career prospects.</p>
                            </div>
                            
                            <div className="bg-white rounded-2xl p-8 shadow-lg border border-slate-200 hover:shadow-xl transition-all">
                                <div className="text-4xl mb-4">🔒</div>
                                <h4 className="text-xl font-semibold text-slate-800 mb-3">Advanced Security</h4>
                                <p className="text-slate-600">Your data and progress are protected with enterprise-grade security measures.</p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Popular Categories */}
                {categories.length > 0 && (
                    <section className="py-16 px-4 sm:px-6 lg:px-8">
                        <div className="max-w-7xl mx-auto">
                            <div className="text-center mb-12">
                                <h3 className="text-4xl font-bold text-slate-800 mb-4">
                                    📂 Popular Categories
                                </h3>
                                <p className="text-xl text-slate-600">
                                    Discover courses across diverse fields of study
                                </p>
                            </div>

                            <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
                                {categories.map((category) => (
                                    <Link
                                        key={category.id}
                                        href={`/courses?category=${category.id}`}
                                        className="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-all border border-slate-200"
                                    >
                                        <div 
                                            className="w-12 h-12 rounded-lg mx-auto mb-3 flex items-center justify-center text-white font-bold"
                                            style={{ backgroundColor: category.color }}
                                        >
                                            {category.icon || category.name.charAt(0)}
                                        </div>
                                        <h4 className="font-semibold text-slate-800">{category.name}</h4>
                                        <p className="text-slate-500 text-sm">
                                            {category.courses_count} courses
                                        </p>
                                    </Link>
                                ))}
                            </div>
                        </div>
                    </section>
                )}

                {/* Featured Courses */}
                {featuredCourses.length > 0 && (
                    <section className="py-16 px-4 sm:px-6 lg:px-8 bg-white/50">
                        <div className="max-w-7xl mx-auto">
                            <div className="text-center mb-12">
                                <h3 className="text-4xl font-bold text-slate-800 mb-4">
                                    ⭐ Featured Courses
                                </h3>
                                <p className="text-xl text-slate-600">
                                    Hand-picked courses from our top instructors
                                </p>
                            </div>

                            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {featuredCourses.map((course) => (
                                    <Link
                                        key={course.id}
                                        href={`/courses/${course.id}`}
                                        className="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all border border-slate-200"
                                    >
                                        <div className="aspect-video bg-gradient-to-r from-slate-200 to-slate-300 flex items-center justify-center">
                                            <div className="text-6xl">🎓</div>
                                        </div>
                                        <div className="p-6">
                                            <div className="flex items-center gap-2 mb-2">
                                                <span 
                                                    className="px-2 py-1 rounded text-xs font-medium text-white"
                                                    style={{ backgroundColor: course.category.color }}
                                                >
                                                    {course.category.name}
                                                </span>
                                                <span className="px-2 py-1 rounded text-xs font-medium bg-slate-100 text-slate-700">
                                                    {course.level}
                                                </span>
                                            </div>
                                            <h4 className="font-semibold text-slate-800 mb-2 line-clamp-2">
                                                {course.title}
                                            </h4>
                                            <p className="text-slate-600 text-sm mb-3 line-clamp-2">
                                                {course.short_description}
                                            </p>
                                            <div className="text-slate-500 text-sm mb-3">
                                                by {course.instructor.name}
                                            </div>
                                            <div className="flex items-center justify-between">
                                                <div className="flex items-center gap-1">
                                                    <span className="text-yellow-500">★</span>
                                                    <span className="text-sm font-medium">
                                                        {course.average_rating.toFixed(1)}
                                                    </span>
                                                    <span className="text-slate-500 text-sm">
                                                        ({formatNumber(course.total_students)})
                                                    </span>
                                                </div>
                                                <div className="font-bold text-lg">
                                                    {formatPrice(course.price, course.is_free)}
                                                </div>
                                            </div>
                                        </div>
                                    </Link>
                                ))}
                            </div>
                        </div>
                    </section>
                )}

                {/* Call to Action */}
                <section className="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-blue-600 to-purple-600">
                    <div className="max-w-4xl mx-auto text-center text-white">
                        <h3 className="text-4xl lg:text-5xl font-bold mb-6">
                            🚀 Ready to Transform Your Career?
                        </h3>
                        <p className="text-xl mb-8 opacity-90">
                            Join EliteLearn Academy today and unlock your potential with courses designed by industry experts.
                        </p>
                        {!auth.user ? (
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link
                                    href={route('register')}
                                    className="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-slate-100 transform hover:scale-105 transition-all shadow-lg"
                                >
                                    🎯 Start Your Journey
                                </Link>
                                <Link
                                    href="/courses"
                                    className="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white hover:text-blue-600 transition-all"
                                >
                                    📖 View All Courses
                                </Link>
                            </div>
                        ) : (
                            <Link
                                href="/courses"
                                className="bg-white text-blue-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-slate-100 transform hover:scale-105 transition-all shadow-lg inline-block"
                            >
                                🔍 Continue Learning
                            </Link>
                        )}
                    </div>
                </section>

                {/* Footer */}
                <footer className="bg-slate-800 text-white py-12 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto">
                        <div className="grid md:grid-cols-4 gap-8">
                            <div className="col-span-2">
                                <div className="flex items-center space-x-2 mb-4">
                                    <div className="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                                        <span className="text-white font-bold text-sm">EL</span>
                                    </div>
                                    <h1 className="text-xl font-bold">EliteLearn Academy</h1>
                                </div>
                                <p className="text-slate-400 mb-4">
                                    Empowering learners worldwide with cutting-edge education technology 
                                    and world-class instruction.
                                </p>
                                <div className="text-sm text-slate-500">
                                    Built with ❤️ by{" "}
                                    <a 
                                        href="https://app.build" 
                                        target="_blank" 
                                        className="text-blue-400 hover:text-blue-300"
                                    >
                                        app.build
                                    </a>
                                </div>
                            </div>
                            <div>
                                <h4 className="font-semibold mb-4">Platform</h4>
                                <ul className="space-y-2 text-slate-400">
                                    <li><Link href="/courses" className="hover:text-white">Browse Courses</Link></li>
                                    <li><Link href="/categories" className="hover:text-white">Categories</Link></li>
                                    <li><Link href="/instructors" className="hover:text-white">Become Instructor</Link></li>
                                </ul>
                            </div>
                            <div>
                                <h4 className="font-semibold mb-4">Support</h4>
                                <ul className="space-y-2 text-slate-400">
                                    <li><Link href="/help" className="hover:text-white">Help Center</Link></li>
                                    <li><Link href="/contact" className="hover:text-white">Contact Us</Link></li>
                                    <li><Link href="/privacy" className="hover:text-white">Privacy Policy</Link></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}