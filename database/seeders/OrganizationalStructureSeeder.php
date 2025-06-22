<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationalStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organizational_structures')->insert([
            [
                'name' => 'Struktur Organisasi',
                'photo' => 'organizational-structures/organisasi-skanka.jpg',
                'description' => 'Struktur Organisasi SMKN 1 Kasreman merupakan gambaran susunan kepemimpinan dan pembagian peran di lingkungan sekolah yang menjadi dasar terciptanya tata kelola pendidikan yang efektif, profesional, dan berintegritas.'
            ],
            [
                'name' => 'Struktur Komite Sekolah',
                'photo' => 'organizational-structures/komite-skanka.jpg',
                'description' => 'Struktur Komite Sekolah SMKN 1 Kasreman menunjukkan susunan keanggotaan yang mewakili peran serta orang tua, masyarakat, dan pihak sekolah dalam mendukung peningkatan mutu pendidikan secara transparan dan kolaboratif.'
            ],
        ]);
    }
}
