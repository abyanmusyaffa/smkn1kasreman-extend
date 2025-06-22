<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('facilities')->insert([
            [
                'name' => 'Lab KKPI',
                'photo' => 'facilities/01JFPCPPW678054TW5G7Z57ZQV.jpg',
                'category' => 'infrastructure'
            ],
            [
                'name' => 'Lab Praktikum TKJ',
                'photo' => 'facilities/01JFPCRP886HCCSFWVDAZNSTXF.jpg',
                'category' => 'infrastructure'
            ],
            [
                'name' => 'Lab Praktikum Akuntansi',
                'photo' => 'facilities/01JFPCSPQ3CSEXKZR88E7Z0TK9.jpg',
                'category' => 'infrastructure'
            ],
            [
                'name' => 'Lab Praktikum Kuliner',
                'photo' => 'facilities/01JFPCTQFNJCRD8WW159GJHSWQ.jpg',
                'category' => 'infrastructure'
            ],
            [
                'name' => 'Lab Praktikum Desain dan Produksi Busana',
                'photo' => 'facilities/01JFPCWK9CSME0TN8739VZZF54.jpeg',
                'category' => 'infrastructure'
            ],
            [
                'name' => 'Kantin',
                'photo' => 'facilities/01JFPCXD52FSDCPGXHCKCWX7GK.jpg',
                'category' => 'infrastructure'
            ],
            [
                'name' => 'Mushola',
                'photo' => 'facilities/01JFPCXTGAMHZGKKQ6ZEN5RDDV.jpg',
                'category' => 'infrastructure'
            ],
            [
                'name' => 'Bussiness Centre',
                'photo' => 'facilities/01JFPCY9SYVM91SMTRQS4HRSJV.jpg',
                'category' => 'infrastructure'
            ],
            [
                'name' => 'Ruang Kelas',
                'photo' => 'facilities/01JFPCZ3QPMT48981T49X4HV36.jpg',
                'category' => 'infrastructure'
            ],
            [
                'name' => 'Perpustakaan',
                'photo' => 'facilities/01JFPCZP5B87XWPG5ATHDW85MF.jpg',
                'category' => 'infrastructure'
            ],
            [
                'name' => 'Mikrotik',
                'photo' => 'facilities/01JFPCZP5B87XWPG5ATHDW85MF.jpg',
                'category' => 'learning'
            ],
            [
                'name' => 'Mesin Jahit',
                'photo' => 'facilities/01JFPCZP5B87XWPG5ATHDW85MF.jpg',
                'category' => 'learning'
            ],
            [
                'name' => 'Proyektor',
                'photo' => 'facilities/01JFPCZP5B87XWPG5ATHDW85MF.jpg',
                'category' => 'learning'
            ],
            [
                'name' => 'Media pemebelajran digital',
                'photo' => 'facilities/01JFPCZP5B87XWPG5ATHDW85MF.jpg',
                'category' => 'learning'
            ],
        ]);
    }
}
