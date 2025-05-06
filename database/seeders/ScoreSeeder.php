<?php

namespace Database\Seeders;

use App\Models\Score;
use App\Models\Alumni;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('score_categories')->insert([
            [
                'name' => 'A. Kelompok Mata Pelajaran Umum'
            ],
            [
                'name' => 'B. Kelompok Mata Pelajaran Kejuruan'
            ],
            [
                'name' => 'C. Muatan Lokal'
            ],
            [
                'name' => 'Mata Pelajaran Pilihan'
            ],
        ]);

        DB::table('subjects')->insert([
            [
                'score_category_id' => '1',
                'major_id' => null,
                'name' => 'Pendidikan Agama Islam dan Budi Pekerti'
            ],
            [
                'score_category_id' => '1',
                'major_id' => null,
                'name' => 'Pendidikan Pancasila'
            ],
            [
                'score_category_id' => '1',
                'major_id' => null,
                'name' => 'Bahasa Indonesia'
            ],
            [
                'score_category_id' => '1',
                'major_id' => null,
                'name' => 'Pendidikan Jasmani Olah Raga dan Kesehatan'
            ],
            [
                'score_category_id' => '1',
                'major_id' => null,
                'name' => 'Sejarah  '
            ],
            [
                'score_category_id' => '1',
                'major_id' => null,
                'name' => 'Seni Budaya'
            ],
            [
                'score_category_id' => '2',
                'major_id' => null,
                'name' => 'Matematika'
            ],
            [
                'score_category_id' => '2',
                'major_id' => null,
                'name' => 'Bahasa Inggris'
            ],
            [
                'score_category_id' => '2',
                'major_id' => null,
                'name' => 'Informatika'
            ],
            [
                'score_category_id' => '2',
                'major_id' => null,
                'name' => 'Projek Ilmu Pengetahuan Alam dan Sosial'
            ],
            [
                'score_category_id' => '2',
                'major_id' => null,
                'name' => 'Dasar-Dasar Program Keahlian'
            ],
            [
                'score_category_id' => '2',
                'major_id' => null,
                'name' => 'Konsentrasi Keahlian'
            ],
            [
                'score_category_id' => '2',
                'major_id' => null,
                'name' => 'Projek Kreatif dan Kewirausahaan'
            ],
            [
                'score_category_id' => '2',
                'major_id' => null,
                'name' => 'Praktik Kerja Lapangan'
            ],
            [
                'score_category_id' => '3',
                'major_id' => null,
                'name' => 'Bahasa dan Sastra Jawa'
            ],
            [
                'score_category_id' => '4',
                'major_id' => 1,
                'name' => 'Komputer Grafis'
            ],
            [
                'score_category_id' => '4',
                'major_id' => 2,
                'name' => 'Layanan Perbankan Syariah'
            ],
            [
                'score_category_id' => '4',
                'major_id' => 3,
                'name' => 'Food and Baverage Service'
            ],
            [
                'score_category_id' => '4',
                'major_id' => 3,
                'name' => 'Frozen Food'
            ],
            [
                'score_category_id' => '4',
                'major_id' => 4,
                'name' => 'Menjahit'
            ],
        ]);

        // Alumni::with('groups.majors')->get()->each(function ($alumni) {
        //     // Ambil major dari group-nya alumni
        //     $majorId = optional($alumni->groups->majors)->id;
        
        //     // Ambil subject yang sesuai major atau yang umum (major_id = null)
        //     $subjects = Subject::whereNull('major_id')
        //         ->orWhere('major_id', $majorId)
        //         ->get();
        
        //     foreach ($subjects as $subject) {
        //         Score::factory()->create([
        //             'alumni_id' => $alumni->id,
        //             'subject_id' => $subject->id,
        //         ]);
        //     }
        // });
    }
}
