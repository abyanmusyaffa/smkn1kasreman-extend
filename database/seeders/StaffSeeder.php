<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'head-master' => 1,
            'vice-master' => 5,
            'head-of-major' => 4,
            'teacher' => 17,
            'staff' => 8,
        ];

        foreach ($categories as $category => $count) {
            for ($i = 0; $i < $count; $i++) {
                DB::table('staff')->insert([
                    'name' => fake()->name(),
                    'photo' => fake()->randomElement(['/default/staff-male.svg', '/default/staff-female.svg']),
                    'role' => fake()->jobTitle(),
                    'category' => $category,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
