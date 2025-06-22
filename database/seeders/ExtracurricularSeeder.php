<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExtracurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('extracurriculars')->insert([
            [
                'logo' => 'default/extracurricular.svg',
                'name' => 'Mading Skanka',
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZSXEXJHEKXRCJSEV1WJ7PK.png',
                'name' => 'Skanka Tari',
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZSYCQTGDXYDRC8Z39FNQVJ.png',
                'name' => 'Paskibraka SMK N 1 Kasreman',
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZSZ1A39E5JNFNW1H680DYG.png',
                'name' => 'Skanka E Sports Team',
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZT3F6CNYBH4HNQRV8CCBK5.png',
                'name' => 'Muska (Multimedia Skanka)',
                'url' => 'https://www.instagram.com/officiall_muska?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZT4NA81S4NVWP57ZAB3RH5.png',
                'name' => 'PMR WIRA Skanka',
                'url' => 'https://www.instagram.com/pmr.wira.skanka?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZT5MJ144AJG2XNX72D3Y71.png',
                'name' => 'Skanka VC',
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZT75WAGV6CV7ZW9FFT3JTS.png',
                'name' => 'Skanka Blue Futsal Club',
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZT9CYG6CGDVSXW5HNB0BN7.png',
                'name' => 'Takmir Masjid At Tarbiyyah',
                'url' => 'https://www.instagram.com/tamaat_skanka?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZTANT1HEW22AYNAM1HCK2V.png',
                'name' => 'OSIS Crew Skanka',
                'url' => 'https://www.instagram.com/osisskanka?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZTBKQQ2QJDNAS6C7EMBKJA.png',
                'name' => 'KPA Skanka',
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZTD55JTB4A5FA1X3148636.png',
                'name' => 'Ambalan DIPKA Skanka',
                'url' => 'https://www.instagram.com/ambalandipka2004?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'extracurriculars/01JFZTDVTZB68H0HJ278YVDXN0.png',
                'name' => 'Skanka FC',
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'logo' => 'default/extracurricular.svg',
                'name' => 'Skanka Potrait',
                'url' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
