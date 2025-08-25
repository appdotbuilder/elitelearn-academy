import React, { useState } from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

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
    courses_count: number;
}

interface Filters {
    search?: string;
    category?: string;
    level?: string;
    price_type?: string;
    sort?: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginationMeta {
    current_page: number;
    from: number;
    to: number;
    total: number;
    per_page: number;
    last_page: number;
}

interface Props {
    courses: {
        data: Course[];
        links: PaginationLink[];
        meta: PaginationMeta;
    };
    categories: Category[];
    filters: Filters;
    [key: string]: unknown;
}

export default function CoursesIndex({ courses, categories, filters }: Props) {
    const [searchTerm, setSearchTerm] = useState(filters.search || '');

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get('/courses', { ...filters, search: searchTerm }, {
            preserveState: true,
        });
    };

    const handleFilterChange = (key: string, value: string) => {
        const newFilters = { ...filters };
        if (value === '' || value === 'all') {
            delete newFilters[key as keyof Filters];
        } else {
            newFilters[key as keyof Filters] = value;
        }
        
        router.get('/courses', newFilters, {
            preserveState: true,
        });
    };

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
        <AppShell>
            <Head title="Browse Courses - EliteLearn Academy" />
            
            <div className="space-y-8">
                {/* Header */}
                <div className="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white">
                    <h1 className="text-4xl font-bold mb-4">📚 Browse Courses</h1>
                    <p className="text-xl opacity-90">
                        Discover your next learning adventure from our extensive course library
                    </p>
                </div>

                {/* Search and Filters */}
                <div className="bg-white rounded-xl p-6 shadow-lg border border-slate-200">
                    <form onSubmit={handleSearch} className="mb-6">
                        <div className="flex gap-4">
                            <div className="flex-1">
                                <input
                                    type="text"
                                    value={searchTerm}
                                    onChange={(e) => setSearchTerm(e.target.value)}
                                    placeholder="🔍 Search courses, topics, or instructors..."
                                    className="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                />
                            </div>
                            <button
                                type="submit"
                                className="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all"
                            >
                                Search
                            </button>
                        </div>
                    </form>

                    <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label className="block text-sm font-medium text-slate-700 mb-2">
                                Category
                            </label>
                            <select
                                value={filters.category || ''}
                                onChange={(e) => handleFilterChange('category', e.target.value)}
                                className="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">All Categories</option>
                                {categories.map((category) => (
                                    <option key={category.id} value={category.id}>
                                        {category.name} ({category.courses_count})
                                    </option>
                                ))}
                            </select>
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 mb-2">
                                Level
                            </label>
                            <select
                                value={filters.level || ''}
                                onChange={(e) => handleFilterChange('level', e.target.value)}
                                className="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">All Levels</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 mb-2">
                                Price
                            </label>
                            <select
                                value={filters.price_type || ''}
                                onChange={(e) => handleFilterChange('price_type', e.target.value)}
                                className="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">All Courses</option>
                                <option value="free">Free Only</option>
                                <option value="paid">Paid Only</option>
                            </select>
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700 mb-2">
                                Sort By
                            </label>
                            <select
                                value={filters.sort || 'popular'}
                                onChange={(e) => handleFilterChange('sort', e.target.value)}
                                className="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="popular">Most Popular</option>
                                <option value="newest">Newest First</option>
                                <option value="rating">Highest Rated</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                            </select>
                        </div>
                    </div>
                </div>

                {/* Results Summary */}
                <div className="flex justify-between items-center">
                    <div className="text-slate-600">
                        Showing {courses.meta.from || 0} - {courses.meta.to || 0} of {courses.meta.total} courses
                    </div>
                    {(filters.search || filters.category || filters.level || filters.price_type) && (
                        <Link
                            href="/courses"
                            className="text-blue-600 hover:text-blue-800 font-medium"
                        >
                            Clear all filters
                        </Link>
                    )}
                </div>

                {/* Course Grid */}
                {courses.data.length > 0 ? (
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {courses.data.map((course) => (
                            <Link
                                key={course.id}
                                href={`/courses/${course.id}`}
                                className="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all border border-slate-200 group"
                            >
                                <div className="aspect-video bg-gradient-to-r from-slate-200 to-slate-300 flex items-center justify-center group-hover:from-blue-100 group-hover:to-purple-100 transition-all">
                                    <div className="text-6xl group-hover:scale-110 transition-transform">
                                        🎓
                                    </div>
                                </div>
                                <div className="p-6">
                                    <div className="flex items-center gap-2 mb-2">
                                        <span 
                                            className="px-2 py-1 rounded text-xs font-medium text-white"
                                            style={{ backgroundColor: course.category.color }}
                                        >
                                            {course.category.name}
                                        </span>
                                        <span className="px-2 py-1 rounded text-xs font-medium bg-slate-100 text-slate-700 capitalize">
                                            {course.level}
                                        </span>
                                    </div>
                                    <h3 className="font-semibold text-slate-800 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                        {course.title}
                                    </h3>
                                    <p className="text-slate-600 text-sm mb-3 line-clamp-2">
                                        {course.short_description}
                                    </p>
                                    <div className="text-slate-500 text-sm mb-3">
                                        👨‍🏫 {course.instructor.name}
                                    </div>
                                    <div className="flex items-center justify-between">
                                        <div className="flex items-center gap-1">
                                            <span className="text-yellow-500">⭐</span>
                                            <span className="text-sm font-medium">
                                                {course.average_rating.toFixed(1)}
                                            </span>
                                            <span className="text-slate-500 text-sm">
                                                ({formatNumber(course.total_students)})
                                            </span>
                                        </div>
                                        <div className="font-bold text-lg text-blue-600">
                                            {formatPrice(course.price, course.is_free)}
                                        </div>
                                    </div>
                                </div>
                            </Link>
                        ))}
                    </div>
                ) : (
                    <div className="text-center py-16">
                        <div className="text-8xl mb-4">🔍</div>
                        <h3 className="text-2xl font-semibold text-slate-800 mb-2">
                            No courses found
                        </h3>
                        <p className="text-slate-600 mb-6">
                            Try adjusting your filters or search terms
                        </p>
                        <Link
                            href="/courses"
                            className="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg font-medium hover:from-blue-700 hover:to-purple-700 transition-all"
                        >
                            View All Courses
                        </Link>
                    </div>
                )}

                {/* Pagination */}
                {courses.links && courses.links.length > 3 && (
                    <div className="flex justify-center">
                        <div className="flex space-x-1">
                            {courses.links.map((link, index) => {
                                if (link.url === null) {
                                    return (
                                        <span
                                            key={index}
                                            className="px-4 py-2 text-slate-400 cursor-not-allowed"
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    );
                                }

                                return (
                                    <Link
                                        key={index}
                                        href={link.url}
                                        className={`px-4 py-2 rounded-lg font-medium transition-all ${
                                            link.active
                                                ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white'
                                                : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50'
                                        }`}
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                    />
                                );
                            })}
                        </div>
                    </div>
                )}
            </div>
        </AppShell>
    );
}