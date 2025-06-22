<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('photos')->insert([
            [
                'photo' => json_encode([
                    "photos/01JFKJQSA1G84JMGPPBHHEETA6.jpg",
                    "photos/01JFKJQSA5SSZTR3B0XT0R5YFN.jpg",
                    "photos/01JFKJQSA80GS1Q42GYY0R3NZZ.jpg"
                ]),
                'type' => 'hero'
            ],
            [
                'photo' => json_encode([
                    "photos/01JFKJQSA1G84JMGPPBHHEETA6.jpg",
                    "photos/01JFKKN0DVFMBMF48ZK5XKQMJW.jpg",
                    "photos/01JFKKN0DZ94RC24A1S5WWW60E.jpg",
                    "photos/01JFKKN0E16A93PFWSVY1R6QXK.jpg",
                    "photos/01JFKKN0E3TYNDHBQ1WZCJW9WT.jpg"
                ]),
                'type' => 'gallery'
            ]
        ]);
    }
}
