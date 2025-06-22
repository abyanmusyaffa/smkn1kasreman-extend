<?php

namespace Database\Seeders;

use App\Models\Alumni;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alumni::factory()->count(20)->create();
    }
}
