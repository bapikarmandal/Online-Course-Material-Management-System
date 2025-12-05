<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create sample faculty
        User::create([
            'name' => 'Faculty User',
            'email' => 'faculty@example.com',
            'password' => bcrypt('password'),
            'role' => 'faculty',
        ]);

        // Create sample student
        User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        // Seed institutes and departments
        $this->call([
            InstituteSeeder::class,
            DepartmentSeeder::class,
        ]);
    }
}
