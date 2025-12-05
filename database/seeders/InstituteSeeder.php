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
                'name' => 'University of Technology',
                'description' => 'Leading technology university offering various engineering and computer science programs.',
            ],
            [
                'name' => 'State University',
                'description' => 'Comprehensive university with programs in arts, sciences, and business.',
            ],
            [
                'name' => 'Medical College',
                'description' => 'Premier medical institution offering MBBS and other health science programs.',
            ],
        ];

        foreach ($institutes as $institute) {
            Institute::create($institute);
        }
    }
}
