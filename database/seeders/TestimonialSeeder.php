<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('testimonials')->insert([
            [
                'alumni_id' => 4,
                'content' => 'Sebagai alumni SMKN 1 Kasreman, saya merasa sangat beruntung bisa mendapatkan pendidikan yang berkualitas di sekolah ini. Pengajaran yang diberikan oleh guru-guru sangat mendalam dan praktis, mempersiapkan kami untuk siap terjun ke dunia kerja. Selain itu, suasana sekolah yang mendukung kreativitas dan pembelajaran juga membantu saya mengembangkan potensi diri. Saya sangat menghargai berbagai fasilitas dan program yang disediakan oleh SMKN 1 Kasreman, yang tidak hanya fokus pada teori, tetapi juga memberikan pengalaman langsung melalui praktek dan magang di dunia industri. Terima kasih SMKN 1 Kasreman, yang telah memberikan bekal berharga untuk perjalanan karir saya.',
                'rating' => 4,
                'position' => fake()->jobTitle(),
                'company' => fake()->company(),
                'show' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'alumni_id' => 5,
                'content' => 'SMKN 1 Kasreman telah memberikan pengalaman luar biasa selama saya belajar di sana. Dengan berbagai kegiatan ekstrakurikuler dan pelajaran yang berfokus pada keahlian praktis, saya merasa lebih siap menghadapi tantangan di dunia profesional. Lingkungan yang mendukung, serta bimbingan dari guru-guru yang berdedikasi, sangat memotivasi saya untuk terus berkembang. Sekolah ini tidak hanya mengajarkan teori, tetapi juga memberikan kesempatan untuk berpraktik langsung, yang sangat membantu saya dalam menjalani karir saat ini. Terima kasih SMKN 1 Kasreman, kalian telah menjadi bagian penting dalam perjalanan hidup saya.',
                'rating' => 5,
                'position' => fake()->jobTitle(),
                'company' => fake()->company(),
                'show' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'alumni_id' => 6,
                'content' => 'Menjadi alumni SMKN 1 Kasreman adalah keputusan terbaik dalam perjalanan hidup saya. Selama menempuh pendidikan di sana, saya mendapatkan pengetahuan dan keterampilan yang sangat berguna dalam dunia kerja. Program pelatihan yang diberikan tidak hanya relevan dengan kebutuhan industri, tetapi juga sangat praktis dan aplikatif. Dukungan dari teman-teman dan guru-guru yang selalu mendukung dan memotivasi sangat berperan dalam perkembangan karir saya. Terima kasih SMKN 1 Kasreman, saya bangga menjadi bagian dari keluarga besar sekolah ini.',
                'rating' => 5,
                'position' => fake()->jobTitle(),
                'company' => fake()->company(),
                'show' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'alumni_id' => 7,
                'content' => 'SMKN 1 Kasreman telah memberikan saya fondasi yang kuat untuk meraih kesuksesan di dunia kerja. Selama bersekolah, saya tidak hanya diajarkan teori, tetapi juga diberikan kesempatan untuk mengasah keterampilan melalui berbagai program praktik yang relevan dengan kebutuhan industri. Pengalaman ini sangat membantu saya dalam menjalani karir saya sekarang. Saya sangat berterima kasih kepada para guru yang selalu mendukung dan membimbing kami untuk menjadi pribadi yang lebih baik. SMKN 1 Kasreman bukan hanya tempat belajar, tetapi juga tempat yang membentuk karakter dan kompetensi saya.',
                'rating' => 5,
                'position' => fake()->jobTitle(),
                'company' => fake()->company(),
                'show' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'alumni_id' => 8,
                'content' => 'Menjadi bagian dari SMKN 1 Kasreman adalah pengalaman yang sangat berharga. Selama di sana, saya tidak hanya belajar materi pelajaran, tetapi juga dipersiapkan untuk menghadapi dunia profesional melalui berbagai keterampilan yang diajarkan. Saya merasa sangat terbantu dengan adanya program magang yang memberikan pengalaman langsung di industri. Guru-guru yang penuh dedikasi dan teman-teman yang mendukung membuat suasana belajar semakin menyenangkan. SMKN 1 Kasreman telah memberi saya banyak peluang untuk berkembang, dan saya sangat bangga menjadi alumni dari sekolah ini.',
                'rating' => 5,
                'position' => fake()->jobTitle(),
                'company' => fake()->company(),
                'show' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'alumni_id' => 9,
                'content' => 'SMKN 1 Kasreman adalah tempat yang tidak hanya mengajarkan saya ilmu pengetahuan, tetapi juga membentuk karakter dan keahlian yang berguna di dunia kerja. Saya sangat berterima kasih atas kesempatan yang diberikan untuk mengikuti berbagai pelatihan dan program magang, yang mempersiapkan saya dengan baik untuk menghadapi tantangan di industri. Dosen dan teman-teman di SMKN 1 Kasreman selalu memberikan dukungan yang luar biasa, menciptakan suasana belajar yang penuh motivasi. Saya bangga bisa menjadi alumni dan terus membawa nama baik sekolah dalam setiap langkah karir saya.',
                'rating' => 5,
                'position' => fake()->jobTitle(),
                'company' => fake()->company(),
                'show' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'alumni_id' => 10,
                'content' => 'SMKN 1 Kasreman telah memberikan banyak sekali pengalaman berharga dalam perjalanan pendidikan saya. Selain memperoleh ilmu yang relevan dengan perkembangan industri, saya juga diajarkan untuk menjadi pribadi yang lebih disiplin dan siap menghadapi tantangan. Pengalaman belajar yang saya dapatkan di sekolah ini tidak hanya membekali saya dengan keterampilan teknis, tetapi juga dengan pemahaman penting tentang kerja sama tim dan etika profesional. Saya sangat bersyukur bisa belajar di SMKN 1 Kasreman, yang tidak hanya mempersiapkan saya untuk dunia kerja, tetapi juga mengajarkan nilai-nilai kehidupan yang sangat berharga',
                'rating' => 4,
                'position' => fake()->jobTitle(),
                'company' => fake()->company(),
                'show' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
