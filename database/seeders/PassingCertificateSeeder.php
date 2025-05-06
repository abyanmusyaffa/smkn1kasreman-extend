<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PassingCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('passing_certificates')->insert([
            [
                'letterhead' => 'Pemerintah Provinsi Jawa Timur
                                Dinas Pendidikan',
                'address' => 'Jalan Raya Ngawi Caruban Km 6 Cangakan, Kasreman, Ngawi, Jawa Timur 63281',
                'school' => '1 Kasreman',
                'npsn' => '20508490',
                'phone' => '08113024555',
                'email' => 'smkn1kasreman@yahoo.co.id',
                'zip_code' => '63281',
                'regency' => 'Ngawi',
                'logo' => '',
                'headmaster' => 'Drs. WIDY HARSONO',
                'nip' => '19660321 199003 1 009'
            ]
        ]);

        // DB::table('send_passing_certificates')->insert([
        //     [
        //         'alumni_id' => 21,
        //         'number' => '420/123/103.6.17.18/2025',
        //         'date' => '2025-04-24'
        //     ]
        // ]);
    }
}
