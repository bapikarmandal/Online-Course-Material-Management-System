<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Institute;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universityOfTech = Institute::where('name', 'University of Technology')->first();
        $stateUniversity = Institute::where('name', 'State University')->first();
        $medicalCollege = Institute::where('name', 'Medical College')->first();

        if ($universityOfTech) {
            $departments = [
                ['name' => 'Computer Science', 'institute_id' => $universityOfTech->id],
                ['name' => 'Electrical Engineering', 'institute_id' => $universityOfTech->id],
                ['name' => 'Mechanical Engineering', 'institute_id' => $universityOfTech->id],
                ['name' => 'Civil Engineering', 'institute_id' => $universityOfTech->id],
            ];
            foreach ($departments as $dept) {
                Department::create($dept);
            }
        }

        if ($stateUniversity) {
            $departments = [
                ['name' => 'Business Administration', 'institute_id' => $stateUniversity->id],
                ['name' => 'English Literature', 'institute_id' => $stateUniversity->id],
                ['name' => 'Mathematics', 'institute_id' => $stateUniversity->id],
                ['name' => 'Physics', 'institute_id' => $stateUniversity->id],
            ];
            foreach ($departments as $dept) {
                Department::create($dept);
            }
        }

        if ($medicalCollege) {
            $departments = [
                ['name' => 'Medicine', 'institute_id' => $medicalCollege->id],
                ['name' => 'Surgery', 'institute_id' => $medicalCollege->id],
                ['name' => 'Pharmacy', 'institute_id' => $medicalCollege->id],
            ];
            foreach ($departments as $dept) {
                Department::create($dept);
            }
        }
    }
}
