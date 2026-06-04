<?php
namespace Database\Seeders;

use App\Models\Institute;
use Illuminate\Database\Seeder;

class InstituteSeeder extends Seeder
{
    public function run(): void
    {
        Institute::create([
            'name' => 'Iswar Chandra Vidyasagar Polytechnic',
            'description' => 'Established in 1957, a premier government engineering institute in Jhargram, West Bengal.',
        ]);
    }
}