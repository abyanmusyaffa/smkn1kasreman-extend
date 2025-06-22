<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schools')->insert([
            'name' => '1 Kasreman',
            'alias' => 'Skanka',
            'logo' => 'logo/01JFHNM46N25GCXYCRS1S5RJ6Z.png',
            'motto' => 'Shaping Excellent Generations, Ready to Work and Compete.',
            'vision' => '<p>&nbsp;Menjadi sekolah menengah kejuruan yang unggul, berwawasan global, dan mampu menghasilkan lulusan yang siap pakai, kompeten, serta berkarakter dalam menghadapi perkembangan dunia industri dan teknologi.&nbsp;</p>',
            'mission' => '<ul><li>Menyediakan pendidikan kejuruan yang berkualitas, relevan dengan kebutuhan dunia industri, dan mengikuti perkembangan teknologi terkini.</li><li>Membekali siswa dengan keterampilan praktis dan teori yang sesuai dengan bidang keahlian mereka, sehingga dapat bersaing di dunia kerja maupun melanjutkan pendidikan ke jenjang yang lebih tinggi.</li><li>Membangun karakter siswa yang profesional, disiplin, berintegritas, serta memiliki etika kerja yang baik dan mampu beradaptasi dalam lingkungan kerja yang dinamis.</li><li>Menjalin kerjasama yang erat dengan berbagai perusahaan dan industri untuk menciptakan peluang magang, pelatihan, dan penempatan kerja bagi siswa.</li><li>Mengembangkan fasilitas pendidikan yang memadai, seperti laboratorium, bengkel, dan ruang praktek, untuk mendukung proses pembelajaran yang efektif dan menyenangkan.</li><li>Mendorong siswa untuk berinovasi, berpikir kreatif, dan mengembangkan kemampuan teknologi yang dapat diimplementasikan dalam dunia kerja dan kehidupan sehari-hari.</li></ul>',
            'url_video_profile' => 'https://youtu.be/RcgFVQsLQL0?si=oG7k5DyXu0iCeeoi',
            'description' => '
                SMKN 1 Kasreman merupakan salah satu sekolah menengah kejuruan yang terletak di Kecamatan Kasreman, Kabupaten Ngawi. Sekolah ini memiliki tujuan utama untuk mencetak generasi muda yang kompeten dan siap menghadapi tantangan dunia kerja maupun melanjutkan pendidikan ke jenjang yang lebih tinggi. Dengan fokus pada pendidikan vokasi, SMKN 1 Kasreman berupaya memberikan keterampilan yang relevan dengan kebutuhan industri modern.

                Sejarah berdirinya SMKN 1 Kasreman dimulai dari inisiatif pemerintah daerah untuk meningkatkan kualitas pendidikan kejuruan di wilayah Ngawi. Didirikan pada tahun yang menjadi tonggak penting dalam pengembangan pendidikan vokasi di daerah tersebut, SMKN 1 Kasreman awalnya hanya memiliki beberapa program keahlian. Namun, seiring berjalannya waktu dan meningkatnya kebutuhan masyarakat akan tenaga kerja terampil, sekolah ini terus berkembang dengan menambah program keahlian baru dan meningkatkan fasilitas yang tersedia.

                Kini, SMKN 1 Kasreman telah menjadi salah satu sekolah kejuruan yang diakui di tingkat lokal maupun regional. Dengan dukungan tenaga pengajar yang kompeten dan fasilitas pendidikan yang memadai, sekolah ini mampu menghasilkan lulusan yang tidak hanya mahir di bidangnya, tetapi juga memiliki karakter yang unggul, seperti disiplin, integritas, dan etika kerja yang baik. Selain itu, SMKN 1 Kasreman juga aktif menjalin kemitraan dengan berbagai industri untuk memberikan pengalaman langsung kepada siswa melalui program magang dan pelatihan.

                Sebagai bagian dari komitmennya untuk terus maju, SMKN 1 Kasreman juga berupaya mengikuti perkembangan teknologi dan dunia industri. Dengan mengintegrasikan teknologi dalam proses pembelajaran, sekolah ini memastikan para siswa mendapatkan keterampilan yang relevan dan dapat bersaing di era globalisasi. Selain itu, berbagai kegiatan ekstrakurikuler juga disediakan untuk mengembangkan bakat dan minat siswa di luar bidang akademik.

                Dengan segala upaya dan dedikasi yang dilakukan, SMKN 1 Kasreman menjadi pilihan tepat bagi siswa yang ingin mengembangkan potensi diri dan meraih masa depan yang lebih cerah melalui pendidikan kejuruan. Sekolah ini tidak hanya menjadi tempat belajar, tetapi juga menjadi wadah untuk membentuk generasi muda yang unggul dan berdaya saing tinggi.
                ',
            'welcome_text' => '
                Assalamu’alaikum Warahmatullahi Wabarakatuh,
                Salam sejahtera bagi kita semua,

                Puji syukur kita panjatkan ke hadirat Allah SWT atas segala limpahan rahmat dan karunia-Nya sehingga SMKN 1 Kasreman dapat terus berkembang menjadi lembaga pendidikan yang unggul dalam membentuk generasi muda yang kompeten, berkarakter, dan siap menghadapi tantangan di era globalisasi.

                Selamat datang di website resmi SMKN 1 Kasreman. Website ini kami hadirkan sebagai media informasi dan komunikasi yang memudahkan seluruh masyarakat, terutama siswa, orang tua, dan mitra kerja, untuk mengenal lebih jauh tentang profil, program, dan berbagai kegiatan yang kami selenggarakan.

                Sebagai sekolah menengah kejuruan, kami berkomitmen untuk menyediakan pendidikan berbasis keahlian yang relevan dengan kebutuhan dunia kerja dan perkembangan teknologi. Dengan berbagai program keahlian yang kami tawarkan, kami berupaya membekali siswa dengan keterampilan yang mumpuni, serta karakter yang unggul seperti disiplin, tanggung jawab, dan etika kerja yang baik.

                Tidak hanya itu, kami juga terus berinovasi dalam meningkatkan kualitas pembelajaran melalui pengembangan fasilitas, pelatihan bagi guru, serta menjalin kerja sama dengan berbagai industri. Dengan sinergi ini, kami berharap dapat memberikan kontribusi nyata dalam mencetak lulusan yang siap bersaing di dunia kerja maupun melanjutkan pendidikan ke jenjang yang lebih tinggi.

                Saya juga mengapresiasi dukungan dan partisipasi seluruh pihak, baik orang tua, guru, staf, maupun masyarakat sekitar, yang terus memberikan semangat dan motivasi bagi kami untuk terus maju. Semoga website ini dapat menjadi sarana yang bermanfaat dalam mendukung visi dan misi SMKN 1 Kasreman.

                Akhir kata, kami mengundang Anda semua untuk terus mendukung SMKN 1 Kasreman agar mampu menjadi sekolah yang lebih unggul dan berprestasi. Semoga Allah SWT senantiasa memberikan keberkahan dan kelancaran dalam setiap langkah kita.

                Wassalamu’alaikum Warahmatullahi Wabarakatuh.',
            'address' => 'Jl. Raya Ngawi Caruban Km 6 Ds. Cargakan, Kec Kasreman, Kab Ngawi, Jawa Timur, 63281',
            'phone' => '08113024555',
            'email' => 'smkn1kasreman@yahoo.co.id',
            'url_instagram' => 'https://www.instagram.com/official_smkn1kasreman?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==',
            'url_facebook' => '',
            'url_youtube' => '',
            'url_tiktok' => 'https://www.tiktok.com/@smkn1kasreman?is_from_webapp=1&sender_device=pc',
            'school_map' => 'logo/01JYBJZJ8SGCHV4Q7Z1V20ET44.jpg'
        ]);
    }
}
