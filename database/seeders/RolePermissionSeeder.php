<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            ['name' => 'create-courses', 'display_name' => 'Create Courses', 'description' => 'Can create new courses'],
            ['name' => 'edit-courses', 'display_name' => 'Edit Courses', 'description' => 'Can edit existing courses'],
            ['name' => 'delete-courses', 'display_name' => 'Delete Courses', 'description' => 'Can delete courses'],
            ['name' => 'approve-courses', 'display_name' => 'Approve Courses', 'description' => 'Can approve or reject courses'],
            ['name' => 'manage-users', 'display_name' => 'Manage Users', 'description' => 'Can manage user accounts'],
            ['name' => 'manage-categories', 'display_name' => 'Manage Categories', 'description' => 'Can manage course categories'],
            ['name' => 'view-analytics', 'display_name' => 'View Analytics', 'description' => 'Can view platform analytics'],
            ['name' => 'enroll-courses', 'display_name' => 'Enroll in Courses', 'description' => 'Can enroll in courses'],
            ['name' => 'leave-reviews', 'display_name' => 'Leave Reviews', 'description' => 'Can leave course reviews'],
            ['name' => 'participate-discussions', 'display_name' => 'Participate in Discussions', 'description' => 'Can participate in course discussions'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(['name' => $permissionData['name']], $permissionData);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin'], [
            'display_name' => 'Administrator',
            'description' => 'Platform administrator with full access',
        ]);

        $instructorRole = Role::firstOrCreate(['name' => 'instructor'], [
            'display_name' => 'Instructor',
            'description' => 'Course instructor who can create and manage courses',
        ]);

        $studentRole = Role::firstOrCreate(['name' => 'student'], [
            'display_name' => 'Student',
            'description' => 'Platform student who can enroll in courses',
        ]);

        // Assign permissions to roles
        $adminRole->permissions()->sync(Permission::all());
        
        $instructorRole->permissions()->sync(
            Permission::whereIn('name', [
                'create-courses',
                'edit-courses',
                'delete-courses',
                'enroll-courses',
                'leave-reviews',
                'participate-discussions',
            ])->pluck('id')
        );

        $studentRole->permissions()->sync(
            Permission::whereIn('name', [
                'enroll-courses',
                'leave-reviews',
                'participate-discussions',
            ])->pluck('id')
        );
    }
}