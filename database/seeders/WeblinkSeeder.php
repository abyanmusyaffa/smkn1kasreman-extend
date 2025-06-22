<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WeblinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('weblinks')->insert([
            [
                'title' => 'Tracer Study',
                'url' => 'http://tracer.smkn1kasreman.test',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'E Raport',
                'url' => 'http://raport.smkn1kasreman.test',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Skanka Exam',
                'url' => 'http://exam.smkn1kasreman.test',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
