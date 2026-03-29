<?php

namespace Database\Seeders;

use App\Models\Institute;
use Illuminate\Database\Seeder;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutes = [
            [
                'name' => 'Iswar Chandra Vidyasagar Polytechnic',
                'description' => 'Established in 1957, Iswar Chandra Vidyasagar Polytechnic (I.C.V. Polytechnic) is a premier government engineering institute located in Sevayatan, Jhargram, West Bengal. Affiliated with the West Bengal State Council of Technical & Vocational Education and Skill Development (WBSCTVESD) and approved by AICTE, the institute has a rich legacy of technical excellence.',
            ],
        ];

        foreach ($institutes as $institute) {
            Institute::create($institute);
        }
    }
}
