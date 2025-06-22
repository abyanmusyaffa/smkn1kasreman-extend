<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('partners')->insert([
            [
                'name' => 'Universitas Amikom Yogyakarta',
                'logo' => 'partners/01JFKSN6W1NC7NQ2R2D39JJNAG.png',
                'address' => 'Jl. Padjajaran, Ring Road Utara, Kel. Condongcatur, Kec. Depok, Kab. Sleman, Prop. Daerah Istimewa Yogyakarta 55283',
                'industry' => json_encode(["Teknologi Informasi", "Akuntansi", "Perbankan"]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'PT. Chemco Harapan Nusantara',
                'logo' => 'partners/01JFKTFBPNE4EEFSBB17EF78JC.png',
                'address' => 'Jababeka Industrial Estate Jl. Jababeka Raya Blok F No.19-28, Cikarang - Bekasi, West Java 17530 Indonesia',
                'industry' => json_encode(["Manufaktur"]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Dinas Kependudukan dan Pencatatan SIpil Kabupaten Ngawi',
                'logo' => 'partners/01JFKTNATX4GJ9KRA3STDZN185.png',
                'address' => 'Mall Pelayanan Publik, Kerek, Margomulyo, Kec. Ngawi, Kabupaten Ngawi, Jawa Timur 63217',
                'industry' => json_encode(["Akuntansi", "Administrasi"]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pemerintah Kabupaten Nagwi',
                'logo' => 'partners/01JFKTRDM0HQG6DMYWW18E9QWZ.png',
                'address' => 'Jl. Teuku Umar No.12, Kluncing, Ketanggi, Kec. Ngawi, Kabupaten Ngawi, Jawa Timur 63211',
                'industry' => json_encode(["Akuntansi", "Administrasi"]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Maju Hardware',
                'logo' => 'partners/01JFKTSXF50S1EWEQ2DB26RMZ6.png',
                'address' => 'Jl. Kutai No.5, Pandean, Kec. Taman Kota Madiun, Jawa Timur 63133',
                'industry' => json_encode(["Teknologi Informasi"]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'PT Dwi Prima Sentosa',
                'logo' => 'partners/01JFKTWJEFVANHMPN08P64D2RA.png',
                'address' => 'Cabean, Karang Tengah Prandon, Kec. Ngawi, Kabupaten Ngawi, Jawa Timur 63218',
                'industry' => json_encode(["Tekstil", "Manufaktur"]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'PT. Wilmar Cahaya indonesia Tbk',
                'logo' => 'partners/01JFKV005SDJSN21PD009B9JKT.png',
                'address' => 'Jl. Khatulistiwa Km. 4,3 Batulayang, Pontianak 78244 - West Kalimantan',
                'industry' => json_encode(["Teknologi Informasi"]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Dinas Komunikasi Dan Informatika Ngawi',
                'logo' => 'partners/01JFKV1MPJ8FXQKP9BH41GYNN2.png',
                'address' => 'Jl. Teuku Umar No.43, Cabean Kidul, Ketanggi, Kec. Ngawi, Kabupaten Ngawi, Jawa Timur 63211',
                'industry' => json_encode(["Teknologi Informasi", "Akuntansi"]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'RM Spesial Soto Boyolali',
                'logo' => 'partners/01JFKV3C4QCJCABQESE8BHHWEN.png',
                'address' => 'Mojosongo, Kab. Boyolali, Jawa tengah, indonesia',
                'industry' => json_encode(["FnB"]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'PT Sinar Solaria',
                'logo' => 'partners/01JFKV70EYNG10FRK79X5QJ8RV.png',
                'address' => 'Pulo Gebang, Kota Jakarta Timur, DKI Jakarta, Indonesia',
                'industry' => json_encode(["FnB"]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
