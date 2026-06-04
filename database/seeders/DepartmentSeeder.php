<?php
namespace Database\Seeders;

use App\Models\Department;
use App\Models\Institute;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $institute = Institute::where('name', 'like', '%Iswar Chandra%')->first();
        if (!$institute) return;

        $departments = [
            ['name' => 'Computer Science & Technology',   'description' => 'CST department with 6 semesters'],
            ['name' => 'Mechanical Engineering',           'description' => 'ME department with 6 semesters'],
            ['name' => 'Electrical Engineering',           'description' => 'EE department with 6 semesters'],
            ['name' => 'Civil Engineering',                'description' => 'CE department with 6 semesters'],
            ['name' => 'Metallurgical Engineering',        'description' => 'MT department with 6 semesters'],
        ];

        foreach ($departments as $dept) {
            Department::create(['institute_id' => $institute->id] + $dept);
        }
    }
}