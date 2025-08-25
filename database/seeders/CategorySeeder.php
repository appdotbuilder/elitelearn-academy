<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'description' => 'Learn modern web development technologies including HTML, CSS, JavaScript, and popular frameworks.',
                'color' => '#3B82F6',
                'icon' => '💻',
                'sort_order' => 1,
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Master mobile app development for iOS and Android platforms.',
                'color' => '#10B981',
                'icon' => '📱',
                'sort_order' => 2,
            ],
            [
                'name' => 'Data Science',
                'description' => 'Explore data analysis, machine learning, and artificial intelligence.',
                'color' => '#8B5CF6',
                'icon' => '📊',
                'sort_order' => 3,
            ],
            [
                'name' => 'Design',
                'description' => 'Learn UI/UX design, graphic design, and creative tools.',
                'color' => '#F59E0B',
                'icon' => '🎨',
                'sort_order' => 4,
            ],
            [
                'name' => 'Business',
                'description' => 'Develop business skills, marketing strategies, and entrepreneurship.',
                'color' => '#EF4444',
                'icon' => '💼',
                'sort_order' => 5,
            ],
            [
                'name' => 'Photography',
                'description' => 'Master photography techniques, editing, and visual storytelling.',
                'color' => '#6366F1',
                'icon' => '📷',
                'sort_order' => 6,
            ],
            [
                'name' => 'Music',
                'description' => 'Learn musical instruments, music theory, and audio production.',
                'color' => '#EC4899',
                'icon' => '🎵',
                'sort_order' => 7,
            ],
            [
                'name' => 'Fitness & Health',
                'description' => 'Improve your physical and mental well-being with expert guidance.',
                'color' => '#14B8A6',
                'icon' => '💪',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $categoryData) {
            $categoryData['slug'] = Str::slug($categoryData['name']);
            Category::firstOrCreate(['slug' => $categoryData['slug']], $categoryData);
        }
    }
}