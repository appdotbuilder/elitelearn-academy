<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\Lesson;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $instructorRole = Role::where('name', 'instructor')->first();
        $studentRole = Role::where('name', 'student')->first();

        // Create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@elitelearn.com'
        ], [
            'name' => 'Admin User',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $admin->roles()->syncWithoutDetaching([$adminRole->id]);

        // Create sample instructors
        $instructors = [
            [
                'name' => 'Dr. Sarah Johnson',
                'email' => 'sarah.johnson@elitelearn.com',
                'bio' => 'Full-stack developer with 10+ years of experience in web technologies. Former senior engineer at Google and Microsoft.',
                'occupation' => 'Senior Software Engineer',
            ],
            [
                'name' => 'Prof. Michael Chen',
                'email' => 'michael.chen@elitelearn.com',
                'bio' => 'Data Science expert and AI researcher. Published author with extensive experience in machine learning applications.',
                'occupation' => 'AI Research Scientist',
            ],
            [
                'name' => 'Emily Rodriguez',
                'email' => 'emily.rodriguez@elitelearn.com',
                'bio' => 'Award-winning UX designer with expertise in creating user-centered digital experiences for Fortune 500 companies.',
                'occupation' => 'UX Design Director',
            ],
            [
                'name' => 'James Wilson',
                'email' => 'james.wilson@elitelearn.com',
                'bio' => 'Mobile development specialist with expertise in iOS and Android. Built apps with millions of downloads.',
                'occupation' => 'Mobile Development Lead',
            ],
        ];

        $instructorUsers = [];
        foreach ($instructors as $instructorData) {
            $instructor = User::firstOrCreate([
                'email' => $instructorData['email']
            ], [
                'name' => $instructorData['name'],
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            $instructor->roles()->syncWithoutDetaching([$instructorRole->id]);

            UserProfile::firstOrCreate([
                'user_id' => $instructor->id
            ], [
                'bio' => $instructorData['bio'],
                'occupation' => $instructorData['occupation'],
                'experience_level' => 'advanced',
            ]);

            $instructorUsers[] = $instructor;
        }

        // Create sample students
        $students = [
            ['name' => 'Alex Thompson', 'email' => 'alex@example.com'],
            ['name' => 'Maria Garcia', 'email' => 'maria@example.com'],
            ['name' => 'David Kim', 'email' => 'david@example.com'],
            ['name' => 'Lisa Brown', 'email' => 'lisa@example.com'],
            ['name' => 'John Davis', 'email' => 'john@example.com'],
        ];

        foreach ($students as $studentData) {
            $student = User::firstOrCreate([
                'email' => $studentData['email']
            ], [
                'name' => $studentData['name'],
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            $student->roles()->syncWithoutDetaching([$studentRole->id]);

            UserProfile::firstOrCreate([
                'user_id' => $student->id
            ], [
                'points' => random_int(50, 500),
                'experience_level' => ['beginner', 'intermediate', 'advanced'][random_int(0, 2)],
            ]);
        }

        // Create sample courses
        $courses = [
            [
                'title' => 'Complete React Developer Course 2024',
                'short_description' => 'Master React.js from beginner to advanced with hands-on projects and real-world applications.',
                'description' => "Learn React.js, the most popular front-end library, from the ground up. This comprehensive course covers everything from JSX and components to advanced concepts like hooks, context, and state management.\n\nYou'll build multiple projects including a task manager, e-commerce site, and social media dashboard. By the end, you'll be ready to land a job as a React developer.",
                'category' => 'Web Development',
                'instructor' => 0,
                'level' => 'intermediate',
                'price' => 89.99,
                'is_free' => false,
                'requirements' => ['Basic HTML, CSS, and JavaScript knowledge', 'A computer with internet connection', 'Text editor (VS Code recommended)'],
                'what_you_will_learn' => [
                    'Build modern React applications from scratch',
                    'Master React Hooks and functional components',
                    'Implement state management with Context API and Redux',
                    'Create responsive and interactive user interfaces',
                    'Deploy React applications to production',
                    'Write clean, maintainable code following best practices'
                ],
                'tags' => ['React', 'JavaScript', 'Frontend', 'Web Development'],
                'duration_minutes' => 1800, // 30 hours
                'featured' => true,
            ],
            [
                'title' => 'Machine Learning with Python: Complete Guide',
                'short_description' => 'Learn machine learning algorithms, data analysis, and AI development using Python and popular libraries.',
                'description' => "Dive deep into machine learning with Python. This course covers supervised and unsupervised learning, neural networks, and practical applications.\n\nYou'll work with real datasets, build predictive models, and learn to use libraries like scikit-learn, pandas, and TensorFlow.",
                'category' => 'Data Science',
                'instructor' => 1,
                'level' => 'advanced',
                'price' => 129.99,
                'is_free' => false,
                'requirements' => ['Python programming fundamentals', 'Basic statistics knowledge', 'Jupyter Notebook setup'],
                'what_you_will_learn' => [
                    'Implement machine learning algorithms from scratch',
                    'Use scikit-learn for model building and evaluation',
                    'Perform data preprocessing and feature engineering',
                    'Build neural networks with TensorFlow',
                    'Create data visualizations with matplotlib and seaborn',
                    'Deploy ML models to production'
                ],
                'tags' => ['Machine Learning', 'Python', 'AI', 'Data Science'],
                'duration_minutes' => 2400, // 40 hours
                'featured' => true,
            ],
            [
                'title' => 'UI/UX Design Masterclass: From Wireframes to Prototypes',
                'short_description' => 'Design beautiful, user-friendly interfaces using industry-standard tools and proven design principles.',
                'description' => "Master the art and science of UI/UX design. Learn design thinking, user research, wireframing, prototyping, and usability testing.\n\nWork with Figma, Adobe XD, and other professional tools to create stunning designs that users love.",
                'category' => 'Design',
                'instructor' => 2,
                'level' => 'beginner',
                'price' => 79.99,
                'is_free' => false,
                'requirements' => ['No prior design experience needed', 'Access to Figma (free)', 'Creative mindset and attention to detail'],
                'what_you_will_learn' => [
                    'Understand user-centered design principles',
                    'Conduct user research and create personas',
                    'Design wireframes and interactive prototypes',
                    'Master Figma and Adobe XD',
                    'Apply color theory and typography',
                    'Present designs to stakeholders effectively'
                ],
                'tags' => ['UI Design', 'UX Design', 'Figma', 'Prototyping'],
                'duration_minutes' => 1500, // 25 hours
                'featured' => true,
            ],
            [
                'title' => 'iOS App Development with Swift',
                'short_description' => 'Build native iOS applications using Swift and Xcode with hands-on projects and App Store deployment.',
                'description' => "Learn to build iOS apps from scratch using Swift and Xcode. This course covers the complete app development lifecycle from design to App Store submission.\n\nYou'll build real apps including a weather app, social media client, and productivity tool.",
                'category' => 'Mobile Development',
                'instructor' => 3,
                'level' => 'intermediate',
                'price' => 99.99,
                'is_free' => false,
                'requirements' => ['Mac computer with Xcode installed', 'Basic programming knowledge helpful', 'iOS device for testing (recommended)'],
                'what_you_will_learn' => [
                    'Master Swift programming language',
                    'Build user interfaces with SwiftUI',
                    'Integrate APIs and handle data',
                    'Implement Core Data for local storage',
                    'Add push notifications and location services',
                    'Submit apps to the App Store'
                ],
                'tags' => ['iOS', 'Swift', 'Mobile', 'SwiftUI'],
                'duration_minutes' => 2100, // 35 hours
                'featured' => false,
            ],
            [
                'title' => 'Introduction to Programming with Python',
                'short_description' => 'Perfect for beginners! Learn programming fundamentals using Python with practical exercises and projects.',
                'description' => "Start your programming journey with Python, one of the most beginner-friendly and versatile programming languages.\n\nThis course covers programming fundamentals, problem-solving techniques, and practical applications.",
                'category' => 'Web Development',
                'instructor' => 0,
                'level' => 'beginner',
                'price' => 0,
                'is_free' => true,
                'requirements' => ['No programming experience needed', 'Computer with internet connection', 'Willingness to learn and practice'],
                'what_you_will_learn' => [
                    'Understand programming fundamentals',
                    'Write clean, readable Python code',
                    'Work with data structures and algorithms',
                    'Handle files and user input',
                    'Build simple applications and games',
                    'Debug and test your code effectively'
                ],
                'tags' => ['Python', 'Beginner', 'Programming', 'Fundamentals'],
                'duration_minutes' => 900, // 15 hours
                'featured' => false,
            ],
            [
                'title' => 'Digital Photography: From Beginner to Pro',
                'short_description' => 'Master photography techniques, composition, lighting, and post-processing to create stunning images.',
                'description' => "Transform your photography skills with this comprehensive course covering both technical and creative aspects.\n\nLearn to use your camera effectively, understand lighting, and edit photos like a professional.",
                'category' => 'Photography',
                'instructor' => 2,
                'level' => 'beginner',
                'price' => 69.99,
                'is_free' => false,
                'requirements' => ['DSLR or mirrorless camera', 'Basic computer skills', 'Adobe Lightroom (trial version OK)'],
                'what_you_will_learn' => [
                    'Master camera settings and manual mode',
                    'Understand composition and visual storytelling',
                    'Work with natural and artificial lighting',
                    'Edit photos in Adobe Lightroom',
                    'Develop your unique photography style',
                    'Build a professional portfolio'
                ],
                'tags' => ['Photography', 'Lightroom', 'Composition', 'Visual Arts'],
                'duration_minutes' => 1200, // 20 hours
                'featured' => false,
            ],
        ];

        $categories = Category::all()->keyBy('name');

        foreach ($courses as $index => $courseData) {
            $instructor = $instructorUsers[$courseData['instructor']];
            $category = $categories[$courseData['category']];

            $course = Course::firstOrCreate([
                'slug' => Str::slug($courseData['title'])
            ], [
                'title' => $courseData['title'],
                'short_description' => $courseData['short_description'],
                'description' => $courseData['description'],
                'instructor_id' => $instructor->id,
                'category_id' => $category->id,
                'level' => $courseData['level'],
                'price' => $courseData['price'],
                'is_free' => $courseData['is_free'],
                'requirements' => $courseData['requirements'],
                'what_you_will_learn' => $courseData['what_you_will_learn'],
                'tags' => $courseData['tags'],
                'duration_minutes' => $courseData['duration_minutes'],
                'total_lessons' => random_int(20, 50),
                'total_students' => random_int(100, 5000),
                'average_rating' => random_int(40, 50) / 10,
                'total_ratings' => random_int(50, 500),
                'status' => 'approved',
                'published_at' => now()->subDays(random_int(1, 30)),
                'featured_until' => $courseData['featured'] ? now()->addDays(30) : null,
            ]);

            // Create sample sections and lessons
            $this->createSampleContent($course);
        }
    }

    protected function createSampleContent(Course $course): void
    {
        $sections = [
            'Getting Started',
            'Fundamentals',
            'Intermediate Concepts',
            'Advanced Topics',
            'Real-World Projects',
            'Best Practices',
        ];

        foreach ($sections as $index => $sectionTitle) {
            $section = CourseSection::firstOrCreate([
                'course_id' => $course->id,
                'title' => $sectionTitle,
            ], [
                'description' => "Learn about {$sectionTitle} in this comprehensive section.",
                'sort_order' => $index + 1,
                'is_published' => true,
            ]);

            // Create 3-5 lessons per section
            $lessonCount = random_int(3, 5);
            for ($i = 1; $i <= $lessonCount; $i++) {
                Lesson::firstOrCreate([
                    'course_id' => $course->id,
                    'section_id' => $section->id,
                    'slug' => Str::slug("{$sectionTitle}-lesson-{$i}"),
                ], [
                    'title' => "{$sectionTitle} - Lesson {$i}",
                    'description' => "Detailed lesson covering important aspects of {$sectionTitle}.",
                    'type' => ['video', 'text', 'quiz'][random_int(0, 2)],
                    'sort_order' => $i,
                    'is_published' => true,
                    'is_free' => ($index === 0 && $i <= 2), // First 2 lessons of first section are free
                    'duration_minutes' => random_int(10, 45),
                ]);
            }
        }
    }
}