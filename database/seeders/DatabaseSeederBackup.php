<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Alumni;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Major;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@skanka.id',
        //     'password' => Hash::make('admin'),
        // ]);
        DB::table('users')->insert([
            [
                'name' => 'Abyan Aufa Alif Musyaffa',
                'username' => 'aby',
                'password' => Hash::make('admin'),
            ],
            [
                'name' => 'Ardin Nafisa',
                'username' => 'ardin',
                'password' => Hash::make('admin'),
            ],
            [
                'name' => 'Arya Jaya',
                'username' => 'arya',
                'password' => Hash::make('admin'),
            ],
        ]);

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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('majors')->insert([
            [
                'expertise_program' => 'Teknik Jaringan Komputer dan Telekomunikasi',
                'expertise_concentration' => 'Teknik Komputer dan Jaringan',
                'alias' => 'TKJ',
                'description' => '<p>Teknik Komputer dan Jaringan (TKJ) adalah bidang keahlian yang fokus pada penguasaan teknologi informasi, khususnya dalam merancang, membangun, dan memelihara sistem jaringan komputer. Konsentrasi ini dirancang untuk memenuhi kebutuhan industri modern yang sangat mengandalkan teknologi digital.</p><h2><strong>Kompetensi yang Dipelajari di TKJ</strong></h2><p>Siswa TKJ dibekali berbagai keterampilan, di antaranya:</p><ol><li><strong>Perakitan dan Pemeliharaan Komputer</strong><ul><li>Merakit komputer dari komponen dasar.</li><li>Melakukan perawatan dan perbaikan perangkat keras.</li></ul></li><li><strong>Administrasi Jaringan</strong><ul><li>Konfigurasi jaringan lokal (LAN) dan luas (WAN).</li><li>Pengelolaan server dan pengguna jaringan.</li></ul></li><li><strong>Keamanan Jaringan</strong><ul><li>Mengidentifikasi ancaman jaringan.</li><li>Menerapkan sistem keamanan seperti firewall dan VPN.</li></ul></li><li><strong>Pemrograman Dasar</strong><ul><li>Membuat skrip sederhana untuk mendukung administrasi jaringan.</li></ul></li></ol><h2><strong>Prospek Kerja Lulusan TKJ</strong></h2><p>Bidang TKJ menawarkan peluang karier yang luas, seperti:</p><ul><li><strong>Teknisi Jaringan</strong><br>Bertanggung jawab atas instalasi dan perawatan jaringan komputer.</li><li><strong>Administrator Sistem</strong><br>Mengelola server dan memastikan ketersediaan layanan IT.</li><li><strong>IT Support</strong><br>Menyelesaikan masalah teknis yang dialami pengguna.</li><li><strong>Cybersecurity Analyst</strong><br>Melindungi data dan sistem dari serangan siber.</li><li><strong>Wirausahawan Teknologi</strong><br>Membuka bisnis di bidang teknologi seperti jasa instalasi jaringan dan penyewaan server.</li></ul><h2><strong>Mengapa Memilih Konsentrasi TKJ?</strong></h2><p>Ada beberapa alasan mengapa TKJ menjadi pilihan yang menarik:</p><ul><li><strong>Kebutuhan Industri yang Tinggi</strong><br>Dengan perkembangan teknologi, tenaga ahli di bidang jaringan sangat dibutuhkan.</li><li><strong>Materi Praktis</strong><br>Siswa belajar melalui praktik langsung yang sesuai dengan kebutuhan dunia kerja.</li><li><strong>Peluang Pengembangan Diri</strong><br>Lulusan TKJ dapat melanjutkan studi ke perguruan tinggi atau mengambil sertifikasi internasional seperti CCNA dan CompTIA Network+.</li></ul><p><br></p><p>Teknik Komputer dan Jaringan adalah salah satu konsentrasi keahlian yang menjanjikan. Dengan keterampilan yang relevan dan peluang karier yang beragam, konsentrasi ini menjadi pilihan tepat bagi siswa yang tertarik dengan dunia teknologi, khususnya jaringan komputer.</p>',
                'study_group' => 2,
                'study_period' => 3,
                'total_students' => 216,
                'logo' => 'majors/logo/tkj.svg',
                'photo' => json_encode([
                    "majors/cover/1007.jpg",
                    "majors/cover/1008.jpg",
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'expertise_program' => 'Akuntansi dan Keuangan Lembaga',
                'expertise_concentration' => 'Akuntansi',
                'alias' => 'AKL',
                'description' => '<p>Akuntansi adalah bidang yang berfokus pada pencatatan, analisis, dan pelaporan keuangan suatu organisasi atau perusahaan. Keahlian ini sangat penting karena menyangkut pengelolaan keuangan yang transparan dan akurat, yang dapat digunakan untuk pengambilan keputusan dan perencanaan keuangan. Akuntansi mencakup berbagai proses yang melibatkan pengukuran, pemrosesan, dan penyajian informasi keuangan.</p><h2><strong>Kompetensi yang Dipelajari dalam Akuntansi</strong></h2><p>Siswa yang memilih konsentrasi Akuntansi akan mempelajari berbagai keterampilan yang relevan di dunia kerja, antara lain:</p><ol><li><strong>Pencatatan Keuangan</strong><ul><li>Menyusun dan mencatat transaksi keuangan perusahaan.</li><li>Memahami prinsip-prinsip dasar akuntansi, seperti sistem pencatatan ganda dan penggunaan akun.</li></ul></li><li><strong>Penyusunan Laporan Keuangan</strong><ul><li>Membuat laporan keuangan seperti neraca, laporan laba rugi, dan laporan arus kas.</li><li>Menganalisis laporan keuangan untuk membantu dalam pengambilan keputusan.</li></ul></li><li><strong>Akuntansi Pajak</strong><ul><li>Menghitung kewajiban pajak perusahaan sesuai dengan peraturan perpajakan yang berlaku.</li><li>Menyusun laporan pajak dan memastikan kepatuhan terhadap peraturan perpajakan.</li></ul></li><li><strong>Akuntansi Manajerial</strong><ul><li>Menganalisis biaya dan pendapatan untuk membantu perencanaan dan pengendalian keuangan perusahaan.</li><li>Menyusun anggaran dan proyeksi keuangan.</li></ul></li><li><strong>Audit dan Pengendalian Internal</strong><ul><li>Menilai keandalan dan akurasi laporan keuangan melalui audit internal.</li><li>Menerapkan prosedur pengendalian internal untuk mencegah penyelewengan atau kesalahan dalam pencatatan keuangan.</li></ul></li></ol><h2><strong>Prospek Kerja Lulusan Akuntansi</strong></h2><p>Lulusan Akuntansi memiliki peluang karier yang sangat luas di berbagai sektor, antara lain:</p><ul><li><strong>Akuntan</strong><br>Bertanggung jawab untuk pencatatan dan penyusunan laporan keuangan perusahaan atau organisasi.</li><li><strong>Auditor</strong><br>Memastikan bahwa laporan keuangan sesuai dengan standar akuntansi dan peraturan yang berlaku.</li><li><strong>Pajak Konsultan</strong><br>Memberikan nasihat terkait perencanaan pajak dan kepatuhan terhadap peraturan perpajakan.</li><li><strong>Manajer Keuangan</strong><br>Mengelola dan merencanakan aspek keuangan perusahaan, seperti anggaran dan investasi.</li><li><strong>Wirausaha di Bidang Jasa Akuntansi</strong><br>Membuka layanan konsultasi akuntansi atau pembukuan untuk usaha kecil dan menengah.</li></ul><h2><strong>Mengapa Memilih Konsentrasi Akuntansi?</strong></h2><p>Berikut beberapa alasan mengapa memilih konsentrasi Akuntansi adalah keputusan yang tepat:</p><ul><li><strong>Peluang Karier yang Luas</strong><br>Semua perusahaan, baik kecil maupun besar, memerlukan akuntan untuk mengelola keuangan mereka, membuka banyak peluang karier.</li><li><strong>Keterampilan yang Dapat Dipertanggungjawabkan</strong><br>Keahlian dalam akuntansi sangat dihargai dan selalu dibutuhkan di dunia profesional.</li><li><strong>Peluang untuk Sertifikasi Profesional</strong><br>Lulusan akuntansi dapat melanjutkan studi dan mendapatkan sertifikasi profesional, seperti CPA (Certified Public Accountant) atau CA (Chartered Accountant).</li><li><strong>Peluang Wirausaha</strong><br>Akuntansi memberikan dasar yang kuat bagi mereka yang ingin memulai bisnis atau membuka jasa konsultasi keuangan.</li></ul><p><br></p><p>Konsentrasi Akuntansi adalah pilihan yang sangat baik bagi mereka yang tertarik dengan pengelolaan keuangan dan memiliki ketelitian tinggi. Dengan peluang karier yang luas dan keterampilan yang dapat diterapkan di berbagai sektor, Akuntansi membuka jalan bagi kesuksesan profesional di dunia kerja.</p>',
                'study_group' => 3,
                'study_period' => 3,
                'total_students' => 324,
                'logo' => 'majors/logo/ak.svg',
                'photo' => json_encode([
                    "majors/cover/1005.jpg",
                    "majors/cover/1006.jpg",
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'expertise_program' => 'Kuliner',
                'expertise_concentration' => 'Kuliner',
                'alias' => 'KL',
                'description' => '<p>Jurusan Kuliner adalah bidang pendidikan yang fokus pada keterampilan memasak dan pengelolaan bisnis makanan. Di dalamnya, siswa diajarkan tidak hanya tentang cara membuat berbagai hidangan, tetapi juga bagaimana mengelola dapur profesional, mengatur manajemen restoran, serta memahami berbagai aspek terkait industri kuliner. Jurusan ini sangat cocok bagi mereka yang memiliki passion di bidang makanan dan minuman serta tertarik untuk berkarier di dunia hospitality.</p><h2><strong>Kompetensi yang Dipelajari dalam Jurusan Kuliner</strong></h2><p>Siswa yang memilih jurusan Kuliner akan mempelajari berbagai kompetensi yang meliputi:</p><ol><li><strong>Dasar-Dasar Memasak</strong><ul><li>Teknik dasar memasak, mulai dari memotong bahan hingga teknik pemasakan yang berbeda.</li><li>Penguasaan berbagai jenis masakan dari berbagai daerah dan negara.</li></ul></li><li><strong>Higiene dan Keamanan Pangan</strong><ul><li>Pentingnya kebersihan dan sanitasi dalam mempersiapkan makanan.</li><li>Pemahaman tentang pengendalian kualitas makanan dan pencegahan penyakit yang ditularkan melalui makanan.</li></ul></li><li><strong>Pengelolaan Dapur</strong><ul><li>Manajemen operasional dapur, pengaturan bahan baku, serta pemeliharaan peralatan dapur.</li><li>Pengelolaan tenaga kerja di dapur, termasuk pembagian tugas dan pelatihan karyawan.</li></ul></li><li><strong>Penyajian dan Dekorasi Makanan</strong><ul><li>Teknik penyajian dan plating yang menarik agar makanan terlihat lebih menggugah selera.</li><li>Kreativitas dalam menghias makanan dan minuman untuk meningkatkan daya tarik visual.</li></ul></li><li><strong>Manajemen Bisnis Kuliner</strong><ul><li>Pengelolaan keuangan, pemasaran, dan operasional restoran atau bisnis kuliner lainnya.</li><li>Pengenalan tentang tren industri kuliner, termasuk restoran, katering, dan usaha makanan lainnya.</li></ul></li></ol><h2><strong>Prospek Kerja Lulusan Jurusan Kuliner</strong></h2><p>Lulusan jurusan Kuliner memiliki banyak peluang karier di berbagai sektor, baik di dalam negeri maupun internasional, seperti:</p><ul><li><strong>Koki Profesional</strong><br>Bekerja di restoran, hotel, atau resort, memimpin tim dapur untuk menyajikan hidangan berkualitas tinggi.</li><li><strong>Pastry Chef</strong><br>Spesialis dalam pembuatan kue, roti, dan makanan manis lainnya.</li><li><strong>Manajer Restoran</strong><br>Mengelola operasional harian restoran, mulai dari pengelolaan staf hingga strategi pemasaran.</li><li><strong>Food Stylist</strong><br>Mengatur presentasi makanan untuk foto atau video yang digunakan dalam iklan atau media sosial.</li><li><strong>Pengusaha Kuliner</strong><br>Memulai bisnis makanan, seperti membuka restoran, katering, atau usaha kuliner lainnya.</li><li><strong>Instruktur Kuliner</strong><br>Mengajar keterampilan memasak di sekolah kuliner atau pusat pelatihan.</li></ul><h2><strong>Mengapa Memilih Jurusan Kuliner?</strong></h2><p>Beberapa alasan mengapa memilih jurusan Kuliner adalah pilihan yang menarik:</p><ul><li><strong>Peluang Karier yang Luas</strong><br>Industri kuliner terus berkembang, menawarkan banyak kesempatan untuk bekerja di berbagai bidang.</li><li><strong>Kreativitas dalam Memasak</strong><br>Jurusan ini memungkinkan Anda untuk berekspresi melalui masakan dan menciptakan inovasi di dunia kuliner.</li><li><strong>Peluang untuk Berwirausaha</strong><br>Jurusan kuliner memberikan bekal untuk memulai bisnis kuliner Anda sendiri, dengan keterampilan yang dibutuhkan untuk sukses dalam industri ini.</li><li><strong>Industri yang Dinamis</strong><br>Dunia kuliner selalu berubah, memberikan kesempatan untuk terus belajar dan mengikuti tren baru.</li></ul><p><br></p><p>Jurusan Kuliner adalah pilihan yang sangat baik bagi mereka yang memiliki minat dan bakat dalam dunia masak-memasak dan ingin mengembangkan karier di industri makanan. Dengan keterampilan yang didapatkan, lulusan kuliner dapat memasuki dunia kerja yang penuh tantangan dan peluang, baik di dalam negeri maupun internasional.</p>',
                'study_group' => 2,
                'study_period' => 3,
                'total_students' => 216,
                'logo' => 'majors/logo/kl.svg',
                'photo' => json_encode([
                    "majors/cover/1003.jpg",
                    "majors/cover/1004.jpg",
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'expertise_program' => 'Desain dan Produksi Busana',
                'expertise_concentration' => 'Busana',
                'alias' => 'DPB',
                'description' => '<p>Desain dan Produksi Busana adalah bidang yang menggabungkan kreativitas dalam merancang pakaian dengan keterampilan teknis dalam produksi busana. Jurusan ini fokus pada pengembangan ide, pembuatan pola, pemilihan bahan, serta pembuatan pakaian yang estetis dan fungsional. Konsentrasi ini sangat cocok bagi mereka yang memiliki minat di dunia fashion dan ingin memahami seluruh proses dari konsep desain hingga produk jadi.</p><h2><strong>Kompetensi yang Dipelajari dalam Desain dan Produksi Busana</strong></h2><p>Siswa yang memilih konsentrasi Desain dan Produksi Busana akan mempelajari keterampilan utama di bidang fashion, antara lain:</p><ol><li><strong>Desain Busana</strong><ul><li>Menggambar dan merancang pakaian sesuai dengan tren mode dan kebutuhan pasar.</li><li>Membuat sketsa, mood board, dan mengembangkan konsep desain pakaian.</li></ul></li><li><strong>Pembuatan Pola dan Teknik Jahit</strong><ul><li>Membuat pola dasar pakaian dan memodifikasinya untuk desain yang lebih kompleks.</li><li>Teknik menjahit dan merakit bahan menjadi pakaian yang siap pakai.</li></ul></li><li><strong>Pemilihan Bahan dan Material</strong><ul><li>Memahami berbagai jenis bahan pakaian dan karakteristiknya.</li><li>Memilih bahan yang sesuai dengan desain dan fungsionalitas pakaian.</li></ul></li><li><strong>Produksi Busana</strong><ul><li>Memahami proses produksi dari sketsa hingga pakaian jadi.</li><li>Mengatur produksi busana dalam skala kecil maupun besar, termasuk manajemen produksi dan pengendalian kualitas.</li></ul></li><li><strong>Pengembangan Koleksi dan Tren Mode</strong><ul><li>Menganalisis tren mode terkini untuk mengembangkan koleksi pakaian yang sesuai dengan pasar sasaran.</li><li>Mengikuti perkembangan industri fashion dan menyesuaikan desain dengan kebutuhan konsumen.</li></ul></li></ol><h2><strong>Prospek Kerja Lulusan Desain dan Produksi Busana</strong></h2><p>Lulusan desain dan produksi busana memiliki banyak peluang kerja di berbagai sektor industri mode, seperti:</p><ul><li><strong>Desainer Busana</strong><br>Mengembangkan koleksi busana untuk rumah mode, butik, atau perusahaan fashion.</li><li><strong>Pola Maker</strong><br>Membuat pola busana berdasarkan desain yang telah dibuat untuk proses produksi.</li><li><strong>Penjahit Profesional</strong><br>Menjahit pakaian custom untuk klien atau dalam produksi massal.</li><li><strong>Manajer Produksi Busana</strong><br>Mengelola dan mengatur jalannya proses produksi pakaian di pabrik atau studio desain.</li><li><strong>Fashion Stylist</strong><br>Bertanggung jawab atas penataan busana untuk pemotretan, acara, atau klien pribadi.</li><li><strong>Pengusaha Fashion</strong><br>Membuka merek atau lini pakaian sendiri, mengelola produksi dan distribusi busana.</li><li><strong>Konsultan Mode</strong><br>Memberikan saran dan ide desain kepada perusahaan atau individu dalam pengembangan busana.</li></ul><h2><strong>Mengapa Memilih Konsentrasi Desain dan Produksi Busana?</strong></h2><p>Beberapa alasan mengapa memilih jurusan Desain dan Produksi Busana adalah pilihan yang tepat:</p><ul><li><strong>Industri Fashion yang Terus Berkembang</strong><br>Dunia mode selalu berkembang dengan cepat, menciptakan berbagai peluang karier dalam berbagai sektor, baik di dalam negeri maupun internasional.</li><li><strong>Kreativitas yang Tak Terbatas</strong><br>Jurusan ini memberikan kebebasan untuk berekspresi dan menciptakan karya-karya busana yang menarik dan inovatif.</li><li><strong>Peluang Berwirausaha</strong><br>Dengan keterampilan desain dan produksi, lulusan dapat memulai bisnis fashion mereka sendiri, seperti butik atau label pakaian.</li><li><strong>Peluang Karier di Berbagai Bidang</strong><br>Selain menjadi desainer, lulusan juga dapat berkarier dalam produksi, manajemen, dan pemasaran busana.</li></ul><p><br></p><p>Jurusan Desain dan Produksi Busana adalah pilihan yang ideal bagi mereka yang memiliki minat dalam dunia mode dan ingin mengembangkan keterampilan kreatif dan teknis. Dengan berbagai peluang karier dan potensi untuk berwirausaha, lulusan dari konsentrasi ini memiliki kesempatan besar untuk sukses di industri fashion yang dinamis.</p>',
                'study_group' => 1,
                'study_period' => 3,
                'total_students' => 108,
                'logo' => 'majors/logo/dpb.svg',
                'photo' => json_encode([
                    "majors/cover/1001.jpg",
                    "majors/cover/1002.jpg",
                ]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
        
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

        DB::table('achievements')->insert([
            [
                'title' => 'Lomba Masak Masakan Tingkat Provinsi Jawa Timur',
                'slug' => 'lomba-masak-masakan-tingkat-provinsi-jawa-timur',
                'rankings' => 'Juara 3',
                'photo' => 'achievements/01JGAN1HA04W8GFFC3P64SH8EE.jpg',
                'content' => '<p>Lomba Masak Masakan Tingkat Provinsi Jawa Timur baru saja selesai diadakan, dan SMKN 1 Kasreman berhasil meraih <strong>Juara 3</strong> dalam kompetisi yang penuh tantangan ini. Lomba yang diikuti oleh berbagai peserta dari seluruh penjuru Jawa Timur ini tidak hanya menjadi ajang untuk menunjukkan keterampilan memasak, tetapi juga sebagai platform untuk melestarikan kuliner tradisional Jawa Timur.</p><h2>Prestasi Mengagumkan SMKN 1 Kasreman</h2><p>Dalam lomba yang berlangsung selama dua hari, para peserta ditantang untuk memasak hidangan-hidangan khas Jawa Timur dengan kreativitas tinggi, teknik yang tepat, dan cita rasa yang autentik. <strong>SMKN 1 Kasreman</strong>, yang diwakili oleh tim siswa dan guru pembimbing, berhasil memukau juri dengan masakan inovatif yang tetap menjaga keaslian rasa tradisional.</p><h3>Menu Andalan SMKN 1 Kasreman</h3><p>Tim dari SMKN 1 Kasreman menyajikan <strong>Rawon</strong>, salah satu masakan khas Jawa Timur, dengan sentuhan modern namun tetap mempertahankan rasa asli yang khas. Berikut adalah beberapa menu yang mereka sajikan dalam lomba:</p><ul><li><strong>Rawon Daging Sapi</strong>: Sup hitam dengan bumbu khas yang menggugah selera.</li><li><strong>Lontong Balap</strong>: Lontong dengan tauge dan sate kerang yang menjadi hidangan khas Surabaya.</li><li><strong>Pindang Ikan Patin</strong>: Masakan sehat yang menggabungkan cita rasa pedas dan asam.</li></ul><p>Keberhasilan ini juga berkat <strong>kerja keras dan kolaborasi</strong> antara para siswa dan guru yang telah mempersiapkan segala sesuatunya dengan matang, dari pemilihan bahan hingga teknik memasak yang digunakan.</p><h2>Proses Penilaian Lomba</h2><p>Lomba masak ini dinilai oleh panel juri yang terdiri dari chef profesional dan ahli kuliner. Para peserta dinilai berdasarkan beberapa aspek penting:</p><h3>1. <strong>Kreativitas dalam Mengolah Bahan</strong></h3><p>Para peserta dituntut untuk memberikan inovasi pada masakan tradisional, yang ditunjukkan dengan kreativitas dalam penggunaan bahan-bahan lokal.</p><h3>2. <strong>Teknik Memasak</strong></h3><p>Penilaian pada teknik memasak sangat penting, di mana peserta harus menjaga kualitas rasa dan tampilan masakan dengan teknik yang tepat.</p><h3>3. <strong>Estetika Penyajian</strong></h3><p>Penyajian masakan yang rapi dan menarik juga menjadi salah satu faktor penilaian, karena dapat meningkatkan daya tarik masakan.</p><h2>Keseruan Lomba Masak</h2><p>Selama lomba berlangsung, banyak acara menarik yang menyertai kompetisi, di antaranya:</p><ul><li><strong>Demo Memasak dari Chef Terkenal</strong><br>Para pengunjung dan peserta dapat melihat langsung bagaimana chef profesional mengolah masakan tradisional dengan cara yang modern dan menarik.</li><li><strong>Pameran Kuliner Jawa Timur</strong><br>Berbagai macam kuliner khas Jawa Timur dipamerkan, dan para peserta dapat mencicipinya untuk mendapatkan inspirasi masakan.</li></ul><h2>Apa Arti Prestasi ini bagi SMKN 1 Kasreman?</h2><p>Meraih <strong>Juara 3</strong> dalam lomba ini adalah sebuah pencapaian yang membanggakan bagi <strong>SMKN 1 Kasreman</strong>, yang menunjukkan bahwa kualitas pendidikan kuliner yang diberikan di sekolah ini sangat berkualitas. Selain itu, keberhasilan ini juga menjadi bukti bahwa para siswa SMKN 1 Kasreman memiliki keterampilan tinggi dalam bidang kuliner dan mampu bersaing di tingkat provinsi.</p><p>Prestasi ini tidak hanya memberikan kebanggaan bagi para peserta, tetapi juga meningkatkan reputasi <strong>SMKN 1 Kasreman</strong> sebagai salah satu sekolah unggulan dalam bidang pendidikan keterampilan memasak di Jawa Timur.</p><h2>Harapan untuk Kedepannya</h2><p>Dengan raihan <strong>Juara 3</strong> ini, SMKN 1 Kasreman berharap untuk terus mengembangkan program pendidikan kuliner mereka, agar semakin banyak siswa yang terinspirasi untuk berkarir di dunia kuliner. Ke depan, tim kuliner SMKN 1 Kasreman bertekad untuk meraih prestasi yang lebih tinggi lagi dan terus melestarikan kuliner khas Jawa Timur.</p>',
                'tags' => json_encode([
                    "Masak",
                    "Kuliner",
                    "Jawa Timur"
                ]),
                'is_pinned' => true,
                'user_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Lomba Networking Mikrotik Kabupaten Ngawi',
                'slug' => 'lomba-networking-mikrotik-kabupaten-ngawi',
                'rankings' => 'Juara 1 ',
                'photo' => 'achievements/01JFMCJDDG1MNYM4EZP9KHJ0SJ.jpg',
                'content' => '<p>Prestasi gemilang kembali diraih oleh <strong>SMKN 1 Kasreman</strong> dalam ajang <strong>Lomba Networking Mikrotik Kabupaten Ngawi</strong>. Tim dari SMKN 1 Kasreman berhasil meraih <strong>Juara 1</strong> dalam kompetisi yang diikuti oleh siswa-siswi dari berbagai sekolah di Kabupaten Ngawi. Kompetisi ini tidak hanya menguji kemampuan teknis, tetapi juga kreativitas dan ketelitian dalam mengelola jaringan komputer berbasis <strong>Mikrotik</strong>.</p><h2>Tentang Lomba Networking Mikrotik</h2><p>Lomba Networking Mikrotik adalah ajang kompetisi teknologi informasi yang bertujuan untuk:</p><ul><li>Mengasah kemampuan siswa dalam pengelolaan jaringan komputer.</li><li>Memperkenalkan teknologi Mikrotik sebagai solusi jaringan modern.</li><li>Meningkatkan minat siswa terhadap dunia teknologi informasi dan komunikasi (TIK).</li></ul><p>Dalam lomba ini, peserta diuji dalam berbagai aspek jaringan, termasuk konfigurasi router, manajemen bandwidth, hingga troubleshooting jaringan.</p><h2>Perjalanan SMKN 1 Kasreman Menuju Juara</h2><p>Tim dari SMKN 1 Kasreman menunjukkan performa luar biasa sepanjang lomba. Dengan bimbingan guru pembimbing yang berpengalaman, para siswa berhasil menyelesaikan setiap tantangan dengan hasil yang memuaskan.</p><h3>Tantangan Lomba</h3><p>Beberapa tantangan yang harus diselesaikan peserta dalam lomba ini antara lain:</p><ol><li><strong>Konfigurasi Router Mikrotik</strong><ul><li>Peserta diminta untuk mengatur jaringan lokal dengan topologi tertentu menggunakan perangkat Mikrotik.</li><li>Konfigurasi meliputi pengaturan IP address, routing, dan DHCP server.</li></ul></li><li><strong>Manajemen Bandwidth</strong><ul><li>Peserta diuji dalam mengatur bandwidth agar jaringan tetap stabil dan efisien.</li><li>Teknik seperti <strong>queue tree</strong> dan <strong>simple queue</strong> menjadi salah satu penilaian penting.</li></ul></li><li><strong>Troubleshooting Jaringan</strong><ul><li>Peserta harus mampu mengidentifikasi dan memperbaiki masalah jaringan dalam waktu yang terbatas.</li></ul></li><li><strong>Keamanan Jaringan</strong><ul><li>Melakukan konfigurasi firewall untuk melindungi jaringan dari ancaman eksternal.</li></ul></li></ol><h3>Kunci Keberhasilan</h3><p>Keberhasilan SMKN 1 Kasreman tidak lepas dari beberapa faktor berikut:</p><ul><li><strong>Kerja Sama Tim</strong>: Setiap anggota tim berkontribusi sesuai keahlian masing-masing.</li><li><strong>Persiapan yang Matang</strong>: Tim telah melakukan latihan intensif sebelum lomba, termasuk simulasi jaringan yang kompleks.</li><li><strong>Penguasaan Teknologi</strong>: Pemahaman mendalam tentang fitur Mikrotik, seperti <strong>Winbox</strong>, <strong>CLI</strong>, dan <strong>Layer 7 Protocol</strong>, menjadi keunggulan tim.</li></ul><h2>Penghargaan dan Apresiasi</h2><p>Sebagai pemenang <strong>Juara 1</strong>, tim dari SMKN 1 Kasreman menerima penghargaan berupa:</p><ul><li><strong>Piala Juara 1</strong>: Sebagai simbol atas prestasi mereka dalam lomba ini.</li><li><strong>Sertifikat Penghargaan</strong>: Yang menunjukkan kompetensi mereka di bidang networking.</li><li><strong>Hadiah Teknologi</strong>: Seperti perangkat jaringan atau voucher pelatihan, untuk mendukung pengembangan keterampilan mereka.</li></ul><p>Selain itu, prestasi ini mendapat apresiasi tinggi dari sekolah dan masyarakat, yang bangga atas pencapaian luar biasa ini.</p><h2>Manfaat Kompetisi bagi Siswa</h2><p>Mengikuti lomba seperti ini memberikan banyak manfaat bagi siswa, antara lain:</p><ul><li><strong>Meningkatkan Kompetensi Teknis</strong>: Siswa mendapatkan pengalaman langsung dalam mengelola jaringan komputer.</li><li><strong>Persiapan Karier</strong>: Kompetisi ini membantu siswa untuk mempersiapkan diri menghadapi tantangan di dunia kerja, terutama di bidang teknologi informasi.</li><li><strong>Pengakuan di Dunia Pendidikan</strong>: Prestasi ini memperkuat reputasi SMKN 1 Kasreman sebagai salah satu sekolah unggulan di bidang teknologi.</li></ul><h2>Harapan untuk Masa Depan</h2><p>Dengan prestasi ini, SMKN 1 Kasreman berharap dapat terus melahirkan siswa-siswa berprestasi yang siap bersaing di tingkat regional, nasional, bahkan internasional. Kompetisi ini juga menjadi motivasi bagi siswa lain untuk meningkatkan keterampilan mereka di bidang teknologi.</p>',
                'tags' => json_encode([
                    "TKJ",
                    "Mikrotik",
                    "Ngawi"
                ]),
                'is_pinned' => true,
                'user_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'MS Excel Competition Binus University 2024',
                'slug' => 'ms-excel-competition-binus-university-2024',
                'rankings' => 'Juara 2',
                'photo' => 'achievements/01JFMCPC0NHY1Y747E47TH8PMJ.jpg',
                'content' => '<p>Prestasi luar biasa kembali ditorehkan oleh <strong>SMKN 1 Kasreman</strong> dalam ajang <strong>MS Excel Competition Binus University 2024</strong>. Kompetisi ini mempertemukan siswa-siswi terbaik dari berbagai sekolah di seluruh Indonesia untuk menunjukkan keahlian mereka dalam pengelolaan data menggunakan Microsoft Excel. SMKN 1 Kasreman berhasil meraih <strong>Juara 2</strong>, membuktikan kemampuan mereka yang luar biasa dalam menghadapi tantangan di dunia teknologi dan data.</p><h2>Tentang MS Excel Competition Binus University</h2><p>MS Excel Competition adalah salah satu kompetisi bergengsi yang diselenggarakan oleh <strong>Binus University</strong> untuk mengasah kemampuan siswa dalam:</p><ul><li><strong>Pengolahan Data</strong>: Mengolah data besar (big data) dengan menggunakan fitur-fitur canggih Microsoft Excel.</li><li><strong>Analisis Data</strong>: Membuat visualisasi data yang efektif dan memberikan wawasan mendalam dari data mentah.</li><li><strong>Efisiensi Kerja</strong>: Menggunakan rumus, makro, dan alat Excel lainnya untuk meningkatkan produktivitas.</li></ul><p>Ajang ini juga menjadi platform bagi siswa untuk berkompetisi, belajar, dan berbagi pengetahuan dalam bidang teknologi informasi.</p><h2>Perjalanan SMKN 1 Kasreman Menuju Juara</h2><p>Dalam kompetisi yang berlangsung di kampus <strong>Binus University</strong>, tim dari SMKN 1 Kasreman tampil memukau dalam setiap tahap perlombaan. Berikut adalah perjalanan mereka:</p><h3>Babak Penyisihan</h3><p>Pada tahap awal, peserta harus menyelesaikan soal-soal pengolahan data yang mencakup:</p><ol><li><strong>Penggunaan Fungsi Dasar Excel</strong><br>Seperti <strong>VLOOKUP</strong>, <strong>HLOOKUP</strong>, <strong>IF</strong>, <strong>SUMIF</strong>, dan <strong>COUNTIF</strong>.</li><li><strong>Pivot Table dan Chart</strong><br>Membuat laporan dinamis dan visualisasi data interaktif.</li><li><strong>Data Cleaning</strong><br>Mengolah data mentah menjadi format yang rapi dan siap analisis.</li></ol><p>Tim SMKN 1 Kasreman berhasil lolos ke babak final dengan skor tinggi berkat ketelitian dan strategi mereka.</p><h3>Babak Final</h3><p>Pada babak final, tantangan menjadi lebih kompleks. Peserta diminta untuk:</p><ul><li><strong>Menganalisis Dataset Besar</strong>: Menggunakan formula kompleks seperti <strong>ARRAY</strong>, <strong>INDEX-MATCH</strong>, dan <strong>TEXT FUNCTIONS</strong>.</li><li><strong>Membuat Dashboard Interaktif</strong>: Menggunakan <strong>Slicer</strong>, <strong>Conditional Formatting</strong>, dan grafik dinamis untuk menyajikan data dalam bentuk yang menarik.</li><li><strong>Studi Kasus</strong>: Menyelesaikan skenario bisnis nyata dengan data mentah, memberikan wawasan yang mendalam, dan membuat rekomendasi berbasis data.</li></ul><p>Tim SMKN 1 Kasreman menunjukkan performa luar biasa dalam semua aspek, meskipun menghadapi kompetitor dari sekolah-sekolah unggulan lainnya.</p><h2>Keunggulan Tim SMKN 1 Kasreman</h2><p>Prestasi ini tidak lepas dari beberapa keunggulan berikut:</p><ul><li><strong>Pemahaman Excel yang Mendalam</strong>: Tim telah menguasai berbagai fitur Excel dari dasar hingga tingkat lanjut.</li><li><strong>Kerja Sama Tim</strong>: Setiap anggota memiliki peran spesifik yang dijalankan dengan baik.</li><li><strong>Persiapan yang Matang</strong>: Latihan intensif dengan simulasi soal-soal kompetisi membuat mereka siap menghadapi tantangan.</li></ul><h2>Penghargaan yang Diterima</h2><p>Sebagai <strong>Juara 2</strong>, tim SMKN 1 Kasreman mendapatkan penghargaan berupa:</p><ol><li><strong>Piala Juara 2</strong>: Simbol kebanggaan atas pencapaian mereka.</li><li><strong>Sertifikat Penghargaan</strong>: Pengakuan resmi dari Binus University atas prestasi mereka.</li><li><strong>Hadiah Uang Tunai</strong>: Sebagai bentuk apresiasi terhadap kemampuan luar biasa mereka.</li></ol><p>Penghargaan ini menjadi bukti nyata bahwa SMKN 1 Kasreman mampu bersaing di tingkat nasional.</p><h2>Manfaat Kompetisi Bagi Siswa</h2><p>Mengikuti MS Excel Competition memberikan banyak manfaat bagi siswa, di antaranya:</p><ul><li><strong>Meningkatkan Keterampilan Teknologi</strong>: Peserta mendapatkan pengalaman nyata dalam menggunakan alat teknologi untuk menyelesaikan masalah.</li><li><strong>Persiapan Dunia Kerja</strong>: Kemampuan Excel yang mendalam adalah salah satu keterampilan yang sangat dibutuhkan di dunia kerja saat ini.</li><li><strong>Meningkatkan Kepercayaan Diri</strong>: Meraih Juara 2 dalam kompetisi nasional menjadi motivasi besar bagi siswa untuk terus belajar dan berkembang.</li></ul><h2>Harapan untuk Masa Depan</h2><p>Keberhasilan ini menjadi motivasi bagi SMKN 1 Kasreman untuk terus meningkatkan kualitas pendidikan di bidang teknologi informasi. Dengan semangat juang yang tinggi, tim berharap dapat meraih juara pertama dalam kompetisi berikutnya dan membawa nama sekolah ke tingkat yang lebih tinggi.</p>',
                'tags' => json_encode([
                    "Binus",
                    "Akuntansi",
                    "Excel"
                ]),
                'is_pinned' => true,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Lomba Desain Busana Batik Surakarta 2023',
                'slug' => 'lomba-desain-busana-batik-surakarta-2023',
                'rankings' => 'Juara 1',
                'photo' => 'achievements/01JFMCSA0ECZ17JWKP577NZ1X1.jpg',
                'content' => '<p><strong>SMKN 1 Kasreman</strong> kembali menorehkan prestasi membanggakan di dunia seni dan kreativitas. Dalam ajang <strong>Lomba Desain Busana Batik Surakarta 2023</strong>, perwakilan dari SMKN 1 Kasreman berhasil meraih <strong>Juara 1</strong>. Kompetisi ini merupakan bagian dari upaya pelestarian budaya batik sebagai warisan budaya Indonesia yang diakui dunia.</p><h2>Tentang Lomba Desain Busana Batik Surakarta</h2><p>Lomba Desain Busana Batik Surakarta adalah ajang tahunan yang mempertemukan desainer muda berbakat dari seluruh Indonesia untuk menampilkan karya terbaik mereka. Tahun ini, kompetisi mengusung tema <strong>“Modernisasi Batik dalam Era Digital”</strong>, yang bertujuan untuk:</p><ul><li>Meningkatkan inovasi dalam desain batik yang tetap mempertahankan nilai tradisional.</li><li>Menginspirasi generasi muda untuk mencintai batik.</li><li>Menciptakan tren busana batik yang relevan dengan kebutuhan masyarakat modern.</li></ul><h2>Perjalanan SMKN 1 Kasreman Menuju Juara</h2><p>Keberhasilan SMKN 1 Kasreman dalam lomba ini tidak lepas dari kerja keras, kreativitas, dan dedikasi siswa yang mewakili sekolah. Berikut adalah perjalanan mereka dalam lomba:</p><h3>Tahap Seleksi Awal</h3><p>Pada tahap ini, peserta diminta untuk mengajukan desain busana batik berdasarkan tema yang ditentukan. Desain dari SMKN 1 Kasreman berhasil mencuri perhatian juri dengan:</p><ol><li><strong>Kombinasi Motif Tradisional dan Modern</strong><br>Desain menggabungkan motif batik khas Solo dengan elemen geometris modern.</li><li><strong>Warna yang Berani dan Harmonis</strong><br>Palet warna yang digunakan mencerminkan keberanian dan kreativitas generasi muda, namun tetap harmonis dan sesuai dengan karakter batik.</li><li><strong>Cerita di Balik Desain</strong><br>Karya yang diajukan memiliki filosofi mendalam tentang harmoni antara tradisi dan inovasi.</li></ol><h3>Tahap Final</h3><p>Pada babak final, peserta harus mempresentasikan desain mereka di hadapan dewan juri yang terdiri dari desainer ternama dan pakar batik. Tantangan utama pada tahap ini adalah:</p><ul><li><strong>Membuat Prototipe Busana</strong><br>Peserta harus mewujudkan desain mereka dalam bentuk busana nyata.</li><li><strong>Presentasi dan Tanya Jawab</strong><br>Peserta memaparkan konsep di balik desain dan menjawab pertanyaan dari juri.</li></ul><p>Tim SMKN 1 Kasreman menunjukkan keunggulan dalam kreativitas dan kemampuan komunikasi, yang membawa mereka ke posisi tertinggi.</p><h2>Penghargaan dan Apresiasi</h2><p>Sebagai <strong>Juara 1</strong>, tim dari SMKN 1 Kasreman menerima penghargaan bergengsi berupa:</p><ol><li><strong>Trophy Juara 1</strong><br>Sebagai pengakuan atas keunggulan desain mereka.</li><li><strong>Sertifikat Penghargaan</strong><br>Sertifikat resmi dari penyelenggara lomba yang menunjukkan prestasi mereka.</li><li><strong>Hadiah Uang Tunai</strong><br>Digunakan untuk mendukung pengembangan kreativitas siswa dalam seni batik.</li><li><strong>Kesempatan Magang</strong><br>Pemenang juga diberikan kesempatan untuk magang di perusahaan batik ternama di Surakarta.</li></ol><p>Prestasi ini tidak hanya membanggakan bagi siswa, tetapi juga menjadi kebanggaan bagi SMKN 1 Kasreman dan masyarakat sekitarnya.</p><h2>Manfaat Kompetisi bagi Siswa</h2><p>Mengikuti lomba ini memberikan banyak manfaat bagi siswa, di antaranya:</p><ul><li><strong>Meningkatkan Kreativitas</strong><br>Siswa belajar untuk berpikir kreatif dalam menggabungkan elemen tradisional dan modern.</li><li><strong>Pelestarian Budaya</strong><br>Kompetisi ini menjadi sarana bagi siswa untuk mencintai dan melestarikan budaya batik.</li><li><strong>Peluang Karier</strong><br>Pengalaman ini membuka peluang bagi siswa untuk berkarier di industri fashion dan desain.</li></ul><h2>Harapan untuk Masa Depan</h2><p>Dengan prestasi ini, SMKN 1 Kasreman berharap dapat terus menghasilkan siswa-siswi berprestasi yang mencintai budaya Indonesia. Lomba ini juga menjadi motivasi bagi siswa lain untuk terus berkarya dan mengembangkan bakat mereka di bidang seni dan budaya.</p>',
                'tags' => json_encode([
                    "DPB",
                    "Busana",
                    "batik",
                    "Surakarta"
                ]),
                'is_pinned' => true,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Lomba Variasi Baris-Berbaris Kabupaten Ngawi',
                'slug' => 'lomba-variasi-baris-berbaris-kabupaten-ngawi',
                'rankings' => ' Juara 3',
                'photo' => 'achievements/01JFMCVS6CXYTKDM2K6E3B0FK3.jpg',
                'content' => '<p><strong>SMKN 1 Kasreman</strong> kembali menunjukkan keunggulan dalam bidang non-akademik dengan meraih <strong>Juara 3</strong> di ajang <strong>Lomba Variasi Baris-Berbaris (VBB) Kabupaten Ngawi</strong>. Kompetisi ini berlangsung dengan meriah dan diikuti oleh berbagai sekolah menengah di Kabupaten Ngawi.</p><h2>Tentang Lomba Variasi Baris-Berbaris</h2><p>Lomba Variasi Baris-Berbaris merupakan ajang yang menguji kekompakan, kreativitas, dan kedisiplinan tim dalam menampilkan gerakan baris-berbaris yang dikombinasikan dengan variasi formasi yang inovatif. Penilaian meliputi:</p><ul><li><strong>Kekompakan</strong>: Seluruh anggota tim bergerak serempak dan selaras.</li><li><strong>Kreativitas</strong>: Desain formasi dan variasi gerakan yang unik dan menarik.</li><li><strong>Ketepatan Waktu</strong>: Kesesuaian dengan durasi waktu yang telah ditentukan.</li><li><strong>Penampilan</strong>: Kerapian dan kepercayaan diri para peserta.</li></ul><p>Lomba ini bertujuan untuk meningkatkan semangat kebersamaan, disiplin, dan kreativitas di kalangan pelajar.</p><h2>Perjalanan Tim SMKN 1 Kasreman</h2><h3>Persiapan Sebelum Lomba</h3><p>Tim SMKN 1 Kasreman telah mempersiapkan diri secara intensif sebelum lomba, dengan latihan rutin yang dipandu oleh pelatih berpengalaman. Beberapa hal yang menjadi fokus utama latihan adalah:</p><ol><li><strong>Sinkronisasi Gerakan</strong>: Agar seluruh anggota tim dapat bergerak dengan ritme yang sama.</li><li><strong>Formasi Inovatif</strong>: Membuat variasi gerakan dan pola yang unik, sesuai dengan tema lomba.</li><li><strong>Penguasaan Teknik Dasar</strong>: Memastikan bahwa semua anggota menguasai teknik baris-berbaris dengan sempurna.</li></ol><h3>Penampilan di Lomba</h3><p>Pada hari pelaksanaan, tim SMKN 1 Kasreman tampil dengan semangat yang luar biasa. Penampilan mereka mendapatkan apresiasi dari para juri dan penonton, terutama karena:</p><ul><li><strong>Variasi Formasi yang Kreatif</strong>: Tim berhasil menciptakan pola formasi yang berbeda dan menarik perhatian.</li><li><strong>Semangat yang Tinggi</strong>: Kekompakan dan semangat tim sangat terasa sepanjang penampilan.</li><li><strong>Ketepatan Gerakan</strong>: Gerakan dilakukan dengan penuh kepercayaan diri dan sesuai dengan aba-aba.</li></ul><h3>Pengumuman Pemenang</h3><p>Setelah melalui proses penilaian yang ketat, SMKN 1 Kasreman dinyatakan meraih <strong>Juara 3</strong>. Hasil ini merupakan pencapaian yang membanggakan, mengingat persaingan yang sangat ketat dengan tim-tim unggulan lainnya.</p><h2>Penghargaan yang Diterima</h2><p>Sebagai Juara 3, tim SMKN 1 Kasreman mendapatkan penghargaan berupa:</p><ol><li><strong>Trophy Juara 3</strong>: Sebagai simbol prestasi dan kebanggaan sekolah.</li><li><strong>Sertifikat Penghargaan</strong>: Bukti resmi atas keberhasilan tim.</li><li><strong>Apresiasi dari Sekolah</strong>: Dukungan penuh dari pihak sekolah untuk terus mengembangkan potensi siswa.</li></ol><h2>Manfaat Kompetisi bagi Siswa</h2><p>Mengikuti lomba ini memberikan banyak manfaat bagi para siswa, di antaranya:</p><ul><li><strong>Melatih Kedisiplinan</strong>: Baris-berbaris membutuhkan kedisiplinan tinggi dari setiap anggota tim.</li><li><strong>Meningkatkan Kekompakan</strong>: Kerja sama tim menjadi faktor utama dalam kesuksesan lomba ini.</li><li><strong>Menumbuhkan Rasa Percaya Diri</strong>: Kesempatan tampil di depan publik memberikan pengalaman berharga bagi siswa.</li></ul><h2>Harapan untuk Masa Depan</h2><p>Keberhasilan ini menjadi motivasi bagi SMKN 1 Kasreman untuk terus berprestasi di bidang lainnya. Dengan latihan dan semangat yang konsisten, tim berharap dapat meraih hasil yang lebih baik di kompetisi mendatang.</p>',
                'tags' => json_encode([
                    "LBB",
                    "Ngawi"
                ]),
                'is_pinned' => false,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Prestasi Gemilang SMKN 1 Kasreman pada Lomba Coding Universitas Amikom Yogyakarta 2024',
                'slug' => 'prestasi-gemilang-smkn-1-kasreman-pada-lomba-coding-universitas-amikom-yogyakarta-2024',
                'rankings' => 'Juara 1',
                'photo' => 'achievements/01JG82KEDR9WJXX8KCKFY93X79.jpg',
                'content' => '<p>SMKN 1 Kasreman kembali mengukir prestasi membanggakan di ajang Lomba Coding Universitas Amikom Yogyakarta 2024. Dalam kompetisi yang diadakan pada bulan Desember 2024, tim dari SMKN 1 Kasreman berhasil meraih posisi juara, mengalahkan peserta dari berbagai sekolah dan universitas.</p><h3>Keberhasilan yang Membanggakan</h3><p>Lomba coding ini diikuti oleh lebih dari 100 peserta dari berbagai latar belakang pendidikan, termasuk pelajar dari SMA, SMK, dan mahasiswa. Dalam kompetisi ini, peserta diuji kemampuan dalam pemrograman komputer, logika algoritma, dan kemampuan menyelesaikan tantangan dalam waktu terbatas. Tim SMKN 1 Kasreman menunjukkan kemampuan luar biasa dengan menyelesaikan seluruh tantangan dalam waktu tercepat.</p><p>Pencapaian yang Diraih</p><p>Berikut adalah beberapa pencapaian yang diraih oleh tim SMKN 1 Kasreman dalam lomba ini:</p><ul><li><strong>Juara 1</strong>: Tim coding SMKN 1 Kasreman berhasil meraih posisi pertama setelah menyelesaikan tantangan dengan solusi yang optimal dan efisien.</li><li><strong>Penghargaan Khusus</strong>: Salah satu anggota tim, Andi Pratama, juga meraih penghargaan khusus sebagai <strong>Peserta dengan Penyelesaian Tercepat</strong>.</li><li><strong>Penghargaan Inovasi</strong>: Tim ini juga mendapatkan penghargaan atas <strong>Inovasi dalam Penggunaan Teknologi Terbaru</strong> dalam menyelesaikan masalah.</li></ul><h3>Tantangan dan Proses Persiapan</h3><p>Untuk mencapai prestasi ini, tim SMKN 1 Kasreman telah mempersiapkan diri dengan matang. Proses persiapan dimulai beberapa bulan sebelum lomba, di mana tim dibimbing oleh para pengajar yang berkompeten di bidang IT dan pemrograman. Latihan intensif dilakukan untuk memperkuat pemahaman tentang algoritma, struktur data, dan pengembangan aplikasi berbasis coding.</p><p>Selain itu, peserta juga menghadapi berbagai tantangan yang menguji ketahanan mental dan kerja sama tim. Berikut adalah beberapa tantangan yang dihadapi oleh tim SMKN 1 Kasreman:</p><ul><li><strong>Tantangan Algoritma Kompleks</strong>: Tim diminta untuk mengembangkan solusi algoritma yang dapat memproses data dalam waktu yang sangat singkat.</li><li><strong>Pengembangan Aplikasi Web</strong>: Dalam waktu terbatas, tim harus membangun aplikasi berbasis web dengan teknologi terbaru.</li><li><strong>Optimasi Kode</strong>: Tim ditantang untuk menulis kode yang tidak hanya tepat, tetapi juga efisien dalam penggunaan sumber daya.</li></ul><h3>Harapan ke Depan</h3><p>Keberhasilan tim SMKN 1 Kasreman di Lomba Coding Universitas Amikom Yogyakarta 2024 menjadi bukti bahwa pendidikan di SMKN 1 Kasreman terus berkembang dan mengikuti perkembangan teknologi terkini. Dengan berbagai penghargaan yang diraih, diharapkan lebih banyak siswa di sekolah ini yang terdorong untuk mengeksplorasi dunia teknologi dan pemrograman.</p><p>Sekolah juga berharap dapat terus berpartisipasi dalam berbagai lomba serupa di masa depan dan terus mencetak prestasi-prestasi gemilang di bidang teknologi.</p>',
                'tags' => json_encode([
                    "Coding",
                    "Amikom Jogja"
                ]),
                'is_pinned' => false,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // User::factory(10)->create()->each(function ($user) {
        //     Alumni::factory()->create([
        //         'user_id' => $user->id,
        //     ]);
        // });
        DB::table('groups')->insert([
            [
                'name' => '12 TKJ 1',
                'major_id' => 1
            ],
            [
                'name' => '12 TKJ 2',
                'major_id' => 1,
            ],
            [
                'name' => '12 AKL 1',
                'major_id' => 2,
            ],
            [
                'name' => '12 AKL 2',
                'major_id' => 2,
            ],
            [
                'name' => '12 AKL 3',
                'major_id' => 2,
            ],
            [
                'name' => '12 KL 1',
                'major_id' => 3,
            ],
            [
                'name' => '12 KL 2',
                'major_id' => 3,
            ],
            [
                'name' => '12 DPB',
                'major_id' => 4
            ],
            [
                'name' => '11 TKJ 1',
                'major_id' => 1
            ],
            [
                'name' => '11 TKJ 2',
                'major_id' => 1,
            ],
            [
                'name' => '11 AKL 1',
                'major_id' => 2,
            ],
            [
                'name' => '11 AKL 2',
                'major_id' => 2,
            ],
            [
                'name' => '11 AKL 3',
                'major_id' => 2,
            ],
            [
                'name' => '11 KL 1',
                'major_id' => 3,
            ],
            [
                'name' => '11 KL 2',
                'major_id' => 3,
            ],
            [
                'name' => '11 DPB',
                'major_id' => 4
            ],
            [
                'name' => '10 TKJ 1',
                'major_id' => 1
            ],
            [
                'name' => '10 TKJ 2',
                'major_id' => 1,
            ],
            [
                'name' => '10 AKL 1',
                'major_id' => 2,
            ],
            [
                'name' => '10 AKL 2',
                'major_id' => 2,
            ],
            [
                'name' => '10 AKL 3',
                'major_id' => 2,
            ],
            [
                'name' => '10 KL 1',
                'major_id' => 3,
            ],
            [
                'name' => '10 KL 2',
                'major_id' => 3,
            ],
            [
                'name' => '10 DPB',
                'major_id' => 4
            ],
        ]);

        Alumni::factory()->count(20)->create();

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

        DB::table('articles')->insert([
            [
                'title' => 'SMKN 1 Kasreman Sukses Gelar Pameran Produk Kreatif Siswa',
                'slug' => 'smkn-1-kasreman-sukses-gelar-pameran-produk-kreatif-siswa',
                'photo' => 'articles/01JFNZXW0TDA9VYWQZA469G51S.jpg',
                'content' => '<p>SMKN 1 Kasreman kembali menunjukkan komitmennya dalam mendukung kreativitas siswa dengan menggelar <strong>Pameran Produk Kreatif Siswa 2024</strong>. Acara yang diadakan di aula sekolah ini berlangsung meriah dan berhasil menarik perhatian masyarakat sekitar, termasuk orang tua siswa, tokoh masyarakat, serta pelaku usaha lokal.</p><h3><strong>Ragam Karya Kreatif Siswa Ditampilkan</strong></h3><p>Pada pameran ini, berbagai karya inovatif dari berbagai jurusan di SMKN 1 Kasreman dipamerkan. Beberapa di antaranya:</p><ul><li><strong>Jurusan Tata Boga</strong>: Aneka makanan dan minuman sehat yang dikemas secara menarik.</li><li><strong>Jurusan Teknik Komputer dan Jaringan (TKJ)</strong>: Prototipe aplikasi sederhana dan perangkat IoT (Internet of Things).</li><li><strong>Jurusan Teknik Otomotif</strong>: Model kendaraan mini dan inovasi alat perbaikan mesin.</li></ul><h3><strong>Antusiasme Pengunjung Sangat Tinggi</strong></h3><p>Salah satu pengunjung, Ibu Sari, menyampaikan kesannya,</p><blockquote><em>“Saya sangat kagum dengan kreativitas siswa SMKN 1 Kasreman. Produk-produk yang dipamerkan menunjukkan potensi besar yang dimiliki anak-anak muda di sini.”</em></blockquote><h3><strong>Tujuan Pameran</strong></h3><p>Pameran ini bertujuan untuk:</p><ol><li><strong>Mendorong semangat kewirausahaan siswa.</strong></li><li><strong>Mengenalkan potensi karya siswa kepada masyarakat.</strong></li><li><strong>Meningkatkan rasa percaya diri siswa dalam menampilkan hasil karya mereka.</strong></li></ol><h3><strong>Dukungan dari Kepala Sekolah</strong></h3><p>Kepala SMKN 1 Kasreman, Bapak Sutrisno, berharap kegiatan seperti ini dapat rutin diadakan.</p><blockquote><em>“Pameran ini bukan hanya tempat siswa memamerkan hasil karya, tetapi juga menjadi awal bagi mereka untuk berkontribusi di masyarakat,”</em> ujarnya.</blockquote><h3><strong>Rencana ke Depan</strong></h3><p>Melihat kesuksesan acara tahun ini, pihak sekolah berencana untuk menjadikan pameran ini sebagai agenda tahunan. Selain itu, akan ada pelatihan lanjutan untuk siswa agar mereka dapat mengembangkan karya menjadi produk yang bernilai jual.</p><p>Dengan suksesnya acara ini, SMKN 1 Kasreman membuktikan bahwa pendidikan vokasi mampu mencetak generasi kreatif dan inovatif.</p>',
                'category' => 'news',
                'tags' => json_encode([
                    "Kreatif"
                ]),
                'is_pinned' => false,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Orang Tua dan Guru SMKN 1 Kasreman Bersinergi dalam Seminar Parenting 2024',
                'slug' => 'orang-tua-dan-guru-smkn-1-kasreman-bersinergi-dalam-seminar-parenting-2024',
                'photo' => 'articles/01JFP00AHQ6DZZMAEPP2EYFA96.jpg',
                'content' => '<p>SMKN 1 Kasreman menggelar <strong>Seminar Parenting 2024</strong> sebagai upaya mempererat hubungan antara orang tua dan guru. Acara ini berlangsung pada Sabtu, 21 Desember 2024, di aula sekolah, dengan tema <em>“Bersama Mendidik Generasi Unggul yang Berkarakter”</em>.</p><h3><strong>Menghadirkan Pembicara Profesional</strong></h3><p>Seminar ini menghadirkan pembicara profesional, <strong>Dr. Anita Wijayanti</strong>, seorang psikolog pendidikan yang telah berpengalaman dalam mendampingi keluarga dan sekolah dalam mendidik anak remaja. Dalam pemaparannya, Dr. Anita menekankan pentingnya komunikasi yang efektif antara orang tua, guru, dan siswa.</p><blockquote><em>“Komunikasi yang baik adalah kunci utama dalam membentuk karakter anak. Orang tua dan guru harus saling mendukung untuk menciptakan lingkungan belajar yang kondusif,”</em> ujar Dr. Anita.</blockquote><h3><strong>Kegiatan Interaktif yang Menginspirasi</strong></h3><p>Seminar ini tidak hanya berisi pemaparan materi, tetapi juga sesi interaktif berupa:</p><ul><li><strong>Diskusi kelompok</strong>: Orang tua dan guru berbagi pengalaman dan tantangan mendidik anak di era digital.</li><li><strong>Simulasi kasus</strong>: Peserta diajak memecahkan masalah perilaku siswa melalui pendekatan kolaboratif.</li><li><strong>Tanya jawab</strong>: Kesempatan bagi peserta untuk bertanya langsung kepada pembicara.</li></ul><h3><strong>Testimoni dari Peserta</strong></h3><p>Para peserta merasa mendapatkan wawasan baru dari seminar ini. Ibu Dewi, salah satu orang tua siswa, mengungkapkan,</p><blockquote><em>“Acara ini sangat bermanfaat. Saya jadi lebih memahami bagaimana cara mendukung anak saya tanpa memberikan tekanan yang berlebihan.”</em></blockquote><p>Sementara itu, Bapak Dedi, salah satu guru, menambahkan,</p><blockquote><em>“Melalui seminar ini, saya bisa melihat bagaimana orang tua berjuang mendidik anak-anak mereka, sehingga saya semakin termotivasi untuk berkontribusi sebagai guru.”</em></blockquote><h3><strong>Komitmen SMKN 1 Kasreman untuk Pendidikan yang Lebih Baik</strong></h3><p>Kepala SMKN 1 Kasreman, Bapak Sutrisno, menyampaikan bahwa kegiatan ini merupakan bagian dari visi sekolah untuk menciptakan lingkungan pendidikan yang inklusif.</p><blockquote><em>“Kami percaya bahwa sinergi antara orang tua dan guru adalah kunci keberhasilan siswa. Melalui seminar ini, kami berharap hubungan tersebut semakin erat,”</em> ujarnya.</blockquote><h3><strong>Harapan dan Rencana Lanjutan</strong></h3><p>Seminar Parenting 2024 ini diakhiri dengan komitmen bersama untuk terus mendukung perkembangan siswa. Pihak sekolah juga berencana mengadakan program lanjutan seperti <strong>pendampingan psikologis</strong> dan <strong>workshop parenting</strong> yang lebih spesifik di masa depan.</p><p>Dengan terselenggaranya seminar ini, SMKN 1 Kasreman kembali menegaskan perannya sebagai institusi pendidikan yang tidak hanya mendidik siswa, tetapi juga melibatkan orang tua sebagai mitra utama dalam proses pendidikan.</p>',
                'category' => 'news',
                'tags' => json_encode([
                    "Parenting"
                ]),
                'is_pinned' => true,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Peringatan Hari Guru Nasional di SMKN 1 Kasreman: Inspirasi untuk Generasi Masa Depan',
                'slug' => 'peringatan-hari-guru-nasional-di-smkn-1-kasreman-inspirasi-untuk-generasi-masa-depan',
                'photo' => 'articles/01JFP038001EYZ180TWQS901F4.jpg',
                'content' => '<p>SMKN 1 Kasreman menggelar peringatan <strong>Hari Guru Nasional 2024</strong> dengan penuh semangat dan kebersamaan. Acara yang berlangsung pada Senin, 25 November 2024, di halaman sekolah ini mengangkat tema <em>“Guru: Inspirasi untuk Generasi Emas Indonesia”</em>.</p><h3><strong>Rangkaian Acara yang Meriah dan Bermakna</strong></h3><p>Acara dimulai dengan upacara bendera yang dipimpin oleh Kepala Sekolah, Bapak Sutrisno. Dalam pidatonya, ia menyampaikan apresiasi mendalam kepada para guru atas dedikasi mereka.</p><blockquote><em>“Guru bukan hanya mengajarkan ilmu, tetapi juga menjadi teladan dalam kehidupan. Mari kita jadikan momen ini sebagai penghargaan atas jasa mereka,”</em> ujarnya.</blockquote><p>Setelah upacara, berbagai kegiatan menarik turut memeriahkan suasana, antara lain:</p><ul><li><strong>Pentas seni siswa</strong>: Menampilkan drama, tarian tradisional, dan musik akustik bertema penghormatan kepada guru.</li><li><strong>Lomba untuk guru dan siswa</strong>: Seperti tarik tambang, estafet, dan tebak kata, yang menciptakan kebersamaan antara siswa dan guru.</li><li><strong>Pemberian penghargaan</strong>: Guru-guru yang telah mengabdi lebih dari 20 tahun mendapatkan penghargaan khusus.</li></ul><h3><strong>Pesan Inspiratif dari Siswa untuk Guru</strong></h3><p>Salah satu momen yang paling menyentuh adalah saat perwakilan siswa menyampaikan pesan dan kesan mereka. Seorang siswa, Rani dari kelas XII TKJ, mengatakan,</p><blockquote><em>“Guru adalah orang tua kedua kami. Terima kasih atas semua ilmu dan bimbingan yang telah diberikan kepada kami.”</em></blockquote><h3><strong>Harapan untuk Masa Depan Pendidikan</strong></h3><p>Peringatan Hari Guru ini juga menjadi refleksi bagi seluruh keluarga besar SMKN 1 Kasreman untuk terus berkomitmen dalam mencetak generasi yang cerdas dan berkarakter. Guru Matematika, Ibu Winda, menyampaikan harapannya,</p><blockquote><em>“Semoga para guru selalu diberi kesehatan dan kekuatan untuk mendidik generasi masa depan. Mari terus berinovasi agar pendidikan semakin maju.”</em></blockquote><h3><strong>Penutup dengan Doa Bersama</strong></h3><p>Acara ditutup dengan doa bersama yang dipimpin oleh guru agama, sebagai wujud syukur atas peran guru dalam membimbing siswa menuju kesuksesan.</p><h3><strong>Makna Hari Guru untuk SMKN 1 Kasreman</strong></h3><p>Peringatan Hari Guru Nasional di SMKN 1 Kasreman bukan sekadar seremoni, tetapi juga pengingat akan pentingnya peran guru dalam membentuk masa depan bangsa. Dengan semangat Hari Guru, sekolah ini terus berkomitmen menciptakan lingkungan belajar yang inspiratif dan bermakna bagi generasi penerus.</p>',
                'category' => 'news',
                'tags' => json_encode([
                    "Hari Guru"
                ]),
                'is_pinned' => false,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Jadwal Pelaksanaan Ujian Tengah Semester (UTS) Tahun Ajaran 2024/2025',
                'slug' => 'jadwal-pelaksanaan-ujian-tengah-semester-uts-tahun-ajaran-20242025',
                'photo' => 'articles/01JFP0GJQCT155FC9P3FX8QGDP.jpg',
                'content' => '<p>SMKN 1 Kasreman mengumumkan pelaksanaan <strong>Ujian Tengah Semester (UTS) Tahun Ajaran 2024/2025</strong> yang akan segera dimulai. UTS merupakan bagian dari evaluasi akademik untuk mengukur pencapaian siswa selama setengah semester pertama.</p><h3><strong>Jadwal Ujian</strong></h3><p>Berikut adalah jadwal pelaksanaan UTS:</p><ul><li><strong>Tanggal</strong>: 14 – 20 Oktober 2024</li><li><strong>Waktu</strong>: Pukul 07.30 – 12.30 WIB</li><li><strong>Lokasi</strong>: Ruang kelas masing-masing</li></ul><p>Jadwal lengkap mata pelajaran dapat dilihat melalui papan pengumuman sekolah atau portal resmi SMKN 1 Kasreman.</p><h3><strong>Persiapan Sebelum Ujian</strong></h3><p>Agar UTS berjalan lancar, siswa diharapkan untuk mempersiapkan diri dengan baik. Berikut beberapa hal yang perlu diperhatikan:</p><ol><li><strong>Cek jadwal ujian</strong>: Pastikan untuk mengetahui jadwal dan mata pelajaran yang akan diujikan setiap hari.</li><li><strong>Membawa perlengkapan lengkap</strong>: Termasuk alat tulis, kartu ujian, dan perlengkapan tambahan jika diperlukan.</li><li><strong>Datang tepat waktu</strong>: Siswa diminta hadir 15 menit sebelum ujian dimulai.</li></ol><h3><strong>Aturan Selama Ujian</strong></h3><p>Untuk menjaga ketertiban, siswa wajib mematuhi aturan berikut:</p><ul><li>Tidak diperbolehkan membawa buku, catatan, atau perangkat elektronik ke dalam ruang ujian.</li><li>Menggunakan seragam sekolah sesuai jadwal hari tersebut.</li><li>Tidak melakukan kecurangan dalam bentuk apapun.</li></ul><h3><strong>Pesan dari Kepala Sekolah</strong></h3><p>Kepala SMKN 1 Kasreman, Bapak Sutrisno, berpesan kepada seluruh siswa,</p><blockquote><em>“UTS adalah momen penting untuk mengevaluasi diri. Manfaatkan waktu yang ada untuk belajar dengan baik dan jaga integritas selama ujian berlangsung.”</em></blockquote><h3><strong>Penutup</strong></h3><p>Demikian informasi mengenai pelaksanaan UTS. Semoga seluruh siswa dapat menjalani ujian dengan lancar dan mendapatkan hasil yang memuaskan. Jika ada pertanyaan lebih lanjut, silakan menghubungi wali kelas masing-masing atau bagian akademik sekolah.</p><p>Mari kita bersama-sama menjaga kelancaran dan keberhasilan UTS ini. Selamat belajar dan semoga sukses!</p><p><br></p><p><a href="instagram.com">Jadwal UTS</a></p>',
                'category' => 'announcement',
                'tags' => json_encode([
                    "UTS"
                ]),
                'is_pinned' => true,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Informasi Libur Akhir Tahun dan Awal Semester Genap',
                'slug' => 'informasi-libur-akhir-tahun-dan-awal-semester-genap',
                'photo' => 'articles/01JFP0JDJFXW6YB5PSCBMZDZWP.jpg',
                'content' => '<p><strong>Pengumuman Libur Akhir Tahun di SMKN 1 Kasreman</strong></p><p>SMKN 1 Kasreman menginformasikan jadwal <strong>libur akhir tahun</strong> bagi seluruh siswa, guru, dan staf. Libur ini diberikan sebagai penutup Semester Ganjil Tahun Ajaran 2024/2025 dan sebagai persiapan memasuki Semester Genap.</p><h3><strong>Jadwal Libur Akhir Tahun</strong></h3><p>Berikut adalah jadwal libur akhir tahun:</p><ul><li><strong>Mulai Libur</strong>: Senin, 23 Desember 2024</li><li><strong>Akhir Libur</strong>: Jumat, 5 Januari 2025</li><li><strong>Masuk Sekolah Kembali</strong>: Senin, 8 Januari 2025</li></ul><p>Selama liburan, siswa diimbau untuk tetap menjaga kesehatan, memanfaatkan waktu dengan baik, dan mempersiapkan diri untuk semester berikutnya.</p><h3><strong>Agenda Setelah Libur</strong></h3><p>Berikut beberapa agenda penting yang akan dilaksanakan setelah libur akhir tahun:</p><ol><li><strong>Pembagian Rapor Semester Ganjil</strong><ul><li><strong>Tanggal</strong>: Sabtu, 20 Januari 2025</li><li><strong>Waktu</strong>: 08.00 – 10.00 WIB</li><li><strong>Lokasi</strong>: Ruang kelas masing-masing.</li></ul></li><li><strong>Mulai Kegiatan Belajar Semester Genap</strong><ul><li><strong>Tanggal</strong>: Senin, 8 Januari 2025</li><li><strong>Waktu</strong>: Sesuai jadwal mata pelajaran baru.</li></ul></li></ol><h3><strong>Pesan dari Kepala Sekolah</strong></h3><p>Kepala SMKN 1 Kasreman, Bapak Sutrisno, memberikan pesan kepada siswa,</p><blockquote><em>“Gunakan libur ini untuk beristirahat dan menghabiskan waktu berkualitas bersama keluarga. Persiapkan diri dengan baik untuk memulai semester baru dengan semangat yang tinggi.”</em></blockquote><h3><strong>Informasi Tambahan</strong></h3><p>Untuk siswa yang memiliki tugas akhir semester atau proyek kelompok, harap memastikan semua pekerjaan selesai sesuai tenggat waktu. Jika ada pertanyaan, siswa dapat menghubungi wali kelas sebelum tanggal 22 Desember 2024.</p><h3><strong>Penutup</strong></h3><p>Semoga libur akhir tahun ini memberikan kesempatan untuk beristirahat dan kembali dengan semangat baru. Selamat menikmati liburan dan selamat Tahun Baru 2025!</p>',
                'category' => 'announcement',
                'tags' => json_encode([
                    "Libur"
                ]),
                'is_pinned' => false,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Informasi Pendaftaran Peserta Didik Baru SMKN 1 Kasreman Tahun Ajaran 2025/2026',
                'slug' => 'informasi-pendaftaran-peserta-didik-baru-smkn-1-kasreman-tahun-ajaran-20252026',
                'photo' => 'articles/01JFP0NCPJHXQSDYWF3601TBA9.jpg',
                'content' => '<p><strong>Pendaftaran Peserta Didik Baru (PPDB) Tahun Ajaran 2025/2026</strong></p><p>SMKN 1 Kasreman membuka <strong>Pendaftaran Peserta Didik Baru (PPDB)</strong> untuk Tahun Ajaran 2025/2026. Pendaftaran ini terbuka bagi calon siswa yang ingin melanjutkan pendidikan di sekolah vokasi terkemuka ini. Berikut adalah informasi lengkap mengenai proses pendaftaran.</p><h3><strong>Jadwal Pendaftaran</strong></h3><p>Pendaftaran PPDB untuk Tahun Ajaran 2025/2026 akan dilaksanakan pada:</p><ul><li><strong>Tanggal Pendaftaran</strong>: 1 – 15 Maret 2025</li><li><strong>Waktu Pendaftaran</strong>: 08.00 – 16.00 WIB (Senin – Jumat)</li><li><strong>Tempat Pendaftaran</strong>: Loket PPDB di SMKN 1 Kasreman atau melalui portal online resmi sekolah</li></ul><h3><strong>Proses Pendaftaran</strong></h3><p>Pendaftaran dapat dilakukan secara <strong>offline</strong> maupun <strong>online</strong> melalui langkah-langkah berikut:</p><ol><li><strong>Offline</strong>:<ul><li>Mengunjungi lokasi pendaftaran di SMKN 1 Kasreman.</li><li>Mengisi formulir pendaftaran dan menyerahkan dokumen persyaratan.</li></ul></li><li><strong>Online</strong>:<ul><li>Mengakses portal resmi PPDB di <strong>www.ppdb.smk1kasreman.sch.id</strong></li><li>Mengisi formulir pendaftaran online dan mengunggah dokumen persyaratan.</li></ul></li></ol><h3><strong>Persyaratan Pendaftaran</strong></h3><p>Berikut adalah dokumen yang perlu dipersiapkan oleh calon peserta didik:</p><ul><li>Fotokopi <strong>Ijazah SD/MI</strong> (untuk lulusan kelas 6 SD/MI).</li><li>Fotokopi <strong>Kartu Keluarga (KK)</strong>.</li><li><strong>Surat Keterangan Sehat</strong> dari dokter.</li><li>Fotokopi <strong>KTP orang tua</strong>.</li><li><strong>Pas foto</strong> terbaru ukuran 3x4 (2 lembar).</li></ul><h3><strong>Jurusan yang Tersedia</strong></h3><p>SMKN 1 Kasreman menyediakan beberapa jurusan unggulan yang dapat dipilih oleh calon siswa, antara lain:</p><ul><li><strong>Tata Boga</strong></li><li><strong>Teknik Komputer dan Jaringan (TKJ)</strong></li><li><strong>Teknik Otomotif</strong></li><li><strong>Multimedia</strong></li><li><strong>Pemasaran</strong></li></ul><h3><strong>Seleksi PPDB</strong></h3><p>Seleksi PPDB akan dilakukan berdasarkan beberapa kriteria, antara lain:</p><ul><li><strong>Nilai Rapor</strong>: Rata-rata nilai rapor dari semester 5 dan 6.</li><li><strong>Tes Kesehatan</strong>: Pemeriksaan kondisi fisik calon siswa.</li><li><strong>Wawancara</strong>: Untuk melihat motivasi dan keseriusan calon siswa.</li></ul><h3><strong>Biaya Pendidikan</strong></h3><p>Informasi mengenai biaya pendidikan dan fasilitas lainnya akan disampaikan setelah proses pendaftaran selesai dan calon siswa diterima. SMKN 1 Kasreman berkomitmen untuk menyediakan biaya yang terjangkau dan mendukung proses pembelajaran siswa.</p><h3><strong>Kontak dan Informasi Lebih Lanjut</strong></h3><p>Untuk informasi lebih lanjut mengenai PPDB SMKN 1 Kasreman, calon peserta didik dapat menghubungi:</p><ul><li><strong>Nomor Telepon</strong>: (0351) 123456</li><li><strong>Email</strong>: ppdb@smk1kasreman.sch.id</li><li><strong>Website</strong>: <a href="www.smk1kasreman.sch.id">www.smk1kasreman.sch.id</a></li></ul><h3><strong>Pesan dari Kepala Sekolah</strong></h3><p>Kepala SMKN 1 Kasreman, Bapak Sutrisno, berharap melalui PPDB ini dapat diterima siswa-siswa terbaik yang siap berkompetisi di dunia kerja dengan keterampilan dan pengetahuan yang memadai.</p><blockquote><em>“Kami mengundang calon siswa yang bersemangat dan siap berkembang untuk bergabung di SMKN 1 Kasreman. Kami yakin, dengan dukungan orang tua dan sekolah, kalian akan mencapai kesuksesan.”</em></blockquote><h3><strong>Penutup</strong></h3><p>Demikian informasi mengenai PPDB SMKN 1 Kasreman Tahun Ajaran 2025/2026. Pastikan untuk mempersiapkan semua dokumen dan mengikuti jadwal pendaftaran yang telah ditentukan. Semoga sukses dan kami tunggu kedatangan Anda di SMKN 1 Kasreman!</p>',
                'category' => 'enrollment',
                'tags' => json_encode([
                    "PPDB"
                ]),
                'is_pinned' => false,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Jadwal dan Syarat Seleksi PPDB SMKN 1 Kasreman Tahun 2025',
                'slug' => 'jadwal-dan-syarat-seleksi-ppdb-smkn-1-kasreman-tahun-2025',
                'photo' => 'articles/01JFP0QGJHHK2Y248Z90VMAB91.jpg',
                'content' => '<p><strong>Pemberitahuan Penting untuk Calon Peserta Didik Baru</strong></p><p>SMKN 1 Kasreman membuka pendaftaran bagi calon peserta didik baru untuk Tahun Ajaran 2025/2026. Proses seleksi ini bertujuan untuk memilih siswa-siswi terbaik yang akan bergabung dalam berbagai jurusan yang tersedia di SMKN 1 Kasreman. Berikut adalah jadwal dan syarat seleksi yang perlu diperhatikan.</p><h3><strong>Jadwal Seleksi PPDB</strong></h3><p>Seleksi untuk penerimaan peserta didik baru akan dilaksanakan sesuai dengan jadwal berikut:</p><ul><li><strong>Pendaftaran Online</strong>: 1 – 15 Maret 2025</li><li><strong>Pengumuman Hasil Seleksi Administrasi</strong>: 18 Maret 2025</li><li><strong>Tes Kesehatan dan Wawancara</strong>: 19 – 21 Maret 2025</li><li><strong>Pengumuman Hasil Seleksi Akhir</strong>: 25 Maret 2025</li><li><strong>Daftar Ulang</strong>: 26 – 28 Maret 2025</li></ul><h3><strong>Syarat Seleksi PPDB</strong></h3><p>Untuk mengikuti seleksi PPDB, calon peserta didik diharapkan memenuhi syarat-syarat berikut:</p><ol><li><strong>Pendidikan</strong>:<ul><li>Lulusan kelas 6 SD/MI atau yang sederajat.</li><li>Mengisi formulir pendaftaran dengan lengkap dan benar.</li></ul></li><li><strong>Dokumen yang Diperlukan</strong>:<ul><li>Fotokopi <strong>Ijazah SD/MI</strong> yang telah dilegalisir.</li><li>Fotokopi <strong>Kartu Keluarga (KK)</strong>.</li><li>Fotokopi <strong>KTP orang tua</strong> (untuk usia lebih dari 17 tahun).</li><li><strong>Surat Keterangan Sehat</strong> dari dokter.</li><li><strong>Pas Foto</strong> terbaru ukuran 3x4 (2 lembar).</li></ul></li><li><strong>Proses Seleksi</strong>:<ul><li><strong>Seleksi Administrasi</strong>: Pemeriksaan kelengkapan dokumen pendaftaran.</li><li><strong>Tes Kesehatan</strong>: Pemeriksaan kondisi fisik dan kesehatan calon peserta didik.</li><li><strong>Wawancara</strong>: Penilaian terhadap motivasi dan kesiapan calon peserta didik untuk bersekolah di SMKN 1 Kasreman.</li></ul></li></ol><h3><strong>Jurusan yang Tersedia</strong></h3><p>SMKN 1 Kasreman menyediakan berbagai jurusan yang dapat dipilih oleh calon siswa, antara lain:</p><ul><li><strong>Tata Boga</strong></li><li><strong>Teknik Komputer dan Jaringan (TKJ)</strong></li><li><strong>Teknik Otomotif</strong></li><li><strong>Multimedia</strong></li><li><strong>Pemasaran</strong></li></ul><h3><strong>Informasi Biaya Pendidikan</strong></h3><p>Biaya pendidikan di SMKN 1 Kasreman akan diinformasikan lebih lanjut setelah calon peserta didik dinyatakan lulus seleksi. Biaya tersebut mencakup biaya pendaftaran, SPP, dan kegiatan sekolah lainnya.</p><h3><strong>Kontak dan Informasi Lebih Lanjut</strong></h3><p>Untuk pertanyaan lebih lanjut atau jika ada informasi yang kurang jelas, calon peserta didik dapat menghubungi:</p><ul><li><strong>Telepon</strong>: (0351) 123456</li><li><strong>Email</strong>: ppdb@smk1kasreman.sch.id</li><li><strong>Website</strong>: <a href="www.smk1kasreman.sch.id">www.smk1kasreman.sch.id</a></li></ul><h3><strong>Pesan dari Kepala Sekolah</strong></h3><p>Kepala SMKN 1 Kasreman, Bapak Sutrisno, mengingatkan kepada semua calon peserta didik,</p><blockquote><em>“Kami mengundang calon siswa yang bersemangat, berintegritas, dan siap berkembang untuk bergabung dengan kami di SMKN 1 Kasreman. Semoga proses seleksi berjalan dengan lancar dan memberikan kesempatan kepada yang terbaik.”</em></blockquote><h3><strong>Penutup</strong></h3><p>Pastikan Anda mengikuti seluruh tahapan seleksi sesuai jadwal yang telah ditentukan dan menyiapkan dokumen dengan lengkap. Semoga sukses dalam proses seleksi dan kami tunggu kehadiran Anda di SMKN 1 Kasreman!</p>',
                'category' => 'enrollment',
                'tags' => json_encode([
                    "PPDB"
                ]),
                'is_pinned' => true,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Pengumuman Pembagian Rapor Semester Ganjil',
                'slug' => 'pengumuman-pembagian-rapor-semester-ganjil',
                'photo' => 'articles/01JG4766C58EDENG2M8T6D0WXC.png',
                'content' => '<p>Sehubungan dengan berakhirnya kegiatan belajar mengajar pada semester ganjil tahun ajaran 2024/2025, SMKN 1 Kasreman menginformasikan kepada seluruh siswa dan orang tua/wali mengenai pembagian rapor.</p><h3>1. Jadwal Pembagian Rapor</h3><p>Pembagian rapor semester ganjil akan dilaksanakan pada:</p><ul><li><strong>Tanggal:</strong> 8 Januari 2025</li><li><strong>Waktu:</strong> Pukul 09.00 WIB – 12.00 WIB</li><li><strong>Tempat:</strong> Ruang Kelas masing-masing</li></ul><h3>2. Prosedur Pembagian Rapor</h3><p>Setiap orang tua/wali siswa diminta untuk hadir langsung pada jadwal yang telah ditentukan. Siswa dapat mengambil rapor di kelas yang telah ditunjuk dengan ditemani oleh orang tua/wali.</p><p><strong>Catatan Penting:</strong></p><ul><li>Bagi siswa yang tidak dapat dihadiri oleh orang tua/wali, dapat diwakilkan oleh saudara yang telah disertakan dengan surat kuasa.</li><li>Harap membawa <strong>bukti pembayaran SPP</strong> bulan Desember 2024 sebagai syarat pengambilan rapor.</li></ul><h3>3. Evaluasi dan Tindak Lanjut</h3><p>Pada kesempatan ini, orang tua/wali dapat berdiskusi langsung dengan wali kelas mengenai perkembangan akademik siswa serta rencana tindak lanjut untuk semester berikutnya.</p><p><strong>Agenda Diskusi:</strong></p><ul><li>Evaluasi hasil belajar semester ganjil.</li><li>Pembahasan perkembangan siswa selama satu semester.</li><li>Rencana kegiatan dan persiapan untuk semester genap.</li></ul><p>Kami berharap seluruh siswa dan orang tua/wali dapat memanfaatkan kesempatan ini dengan sebaik-baiknya. Terima kasih atas kerjasama yang baik selama satu semester ini. Mari kita tingkatkan semangat belajar untuk menghadapi semester genap yang akan datang.</p><p>Untuk informasi lebih lanjut, silakan hubungi:</p><ul><li><strong>Wakil Kepala Sekolah Bidang Kesiswaan:</strong> Bapak Ahmad Fauzi</li><li><strong>Kontak:</strong> (0341) 123-4567</li></ul>',
                'category' => 'announcement',
                'tags' => json_encode([
                    "Raport"
                ]),
                'is_pinned' => false,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('facilities')->insert([
            [
                'name' => 'Lab KKPI',
                'photo' => 'facilities/01JFPCPPW678054TW5G7Z57ZQV.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Lab Praktikum TKJ',
                'photo' => 'facilities/01JFPCRP886HCCSFWVDAZNSTXF.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Lab praktikum Akuntansi',
                'photo' => 'facilities/01JFPCSPQ3CSEXKZR88E7Z0TK9.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Lab Praktikum Kuliner',
                'photo' => 'facilities/01JFPCTQFNJCRD8WW159GJHSWQ.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Lab Praktikum Desain dan Produksi Busana',
                'photo' => 'facilities/01JFPCWK9CSME0TN8739VZZF54.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Kantin',
                'photo' => 'facilities/01JFPCXD52FSDCPGXHCKCWX7GK.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mushola',
                'photo' => 'facilities/01JFPCXTGAMHZGKKQ6ZEN5RDDV.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bussiness Centre',
                'photo' => 'facilities/01JFPCY9SYVM91SMTRQS4HRSJV.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ruang Kelas',
                'photo' => 'facilities/01JFPCZ3QPMT48981T49X4HV36.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Perpustakaan',
                'photo' => 'facilities/01JFPCZP5B87XWPG5ATHDW85MF.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $categories = [
            'head-master' => 1,
            'vice-master' => 5,
            'head-of-major' => 4,
            'teacher' => 17,
            'staff' => 8,
        ];

        foreach ($categories as $category => $count) {
            for ($i = 0; $i < $count; $i++) {
                DB::table('staff')->insert([
                    'name' => fake()->name(),
                    'photo' => fake()->randomElement(['/default/staff-male.svg', '/default/staff-female.svg']),
                    'role' => fake()->jobTitle(),
                    'category' => $category,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

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

        DB::table('downloads')->insert([
            'content' => '<p>Logo SMK N 1 Kasreman</p><p><figure data-trix-attachment="{&quot;contentType&quot;:&quot;image/png&quot;,&quot;filename&quot;:&quot;logo-skanka.png&quot;,&quot;filesize&quot;:1292837,&quot;height&quot;:1280,&quot;href&quot;:&quot;http://smkn1kasreman.test/storage/attachments-download/Yuxuu52Y2f8CSrWO8UwebmkwhpOsqudQKBghc2A6.png&quot;,&quot;url&quot;:&quot;http://smkn1kasreman.test/storage/attachments-download/Yuxuu52Y2f8CSrWO8UwebmkwhpOsqudQKBghc2A6.png&quot;,&quot;width&quot;:1280}" data-trix-content-type="image/png" data-trix-attributes="{&quot;presentation&quot;:&quot;gallery&quot;}" class="attachment attachment--preview attachment--png"><a href="http://smkn1kasreman.test/storage/attachments-download/Yuxuu52Y2f8CSrWO8UwebmkwhpOsqudQKBghc2A6.png"><img src="http://smkn1kasreman.test/storage/attachments-download/Yuxuu52Y2f8CSrWO8UwebmkwhpOsqudQKBghc2A6.png" width="1280" height="1280"><figcaption class="attachment__caption"><span class="attachment__name">logo-skanka.png</span> <span class="attachment__size">1.23 MB</span></figcaption></a></figure><a href="https://drive.google.com/file/d/1TZUU8Sj6mLM3djWb4f_XwY3daf4E42fK/view">Download</a></p>'
        ]);

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

        DB::table('jobfairs')->insert([
            [
                'title' => 'Programmer di PT Teknologi Maju Sejahtera',
                'slug' => 'programmer-di-pt-teknologi-maju-sejahtera',
                'photo' => 'jobfairs/01JG58DMZS82ZD18VBX9EKNJGQ.jpg',
                'deadline' => '2024-12-27 14:30:00',
                'content' => '<p>PT Teknologi Maju Sejahtera membuka peluang karir bagi lulusan SMK dengan posisi <strong>Teknisi Jaringan dan Perangkat Keras</strong>. Kami mencari individu yang bersemangat, teliti, dan memiliki kemauan untuk belajar dalam lingkungan kerja yang dinamis.</p><p><strong>Lokasi Kerja</strong>:</p><ul><li>Kantor Pusat: Jl. Industri No. 10, Surabaya</li><li>Kantor Cabang: Seluruh Indonesia</li></ul><h3>Kualifikasi yang Dibutuhkan</h3><ul><li><strong>Pendidikan</strong>: Lulusan SMK jurusan Teknik Komputer dan Jaringan (TKJ) atau sejenisnya.</li><li><strong>Keahlian</strong>:<ul><li>Memahami dasar-dasar jaringan komputer.</li><li>Berpengalaman dalam instalasi perangkat keras (hardware).</li><li>Dapat bekerja dalam tim maupun individu.</li></ul></li><li><strong>Usia</strong>: Maksimal 25 tahun.</li><li>Bersedia ditempatkan di luar kota apabila diperlukan.</li></ul><h3>Tanggung Jawab</h3><ol><li>Mengelola instalasi dan konfigurasi perangkat jaringan.</li><li>Melakukan troubleshooting terhadap perangkat keras yang bermasalah.</li><li>Mendokumentasikan pekerjaan secara rapi dan jelas.</li><li>Berkoordinasi dengan tim untuk menyelesaikan proyek tepat waktu.</li></ol><h3>Fasilitas yang Didapatkan</h3><ul><li>Gaji pokok sesuai UMK.</li><li>Tunjangan transportasi dan makan.</li><li>Pelatihan dan pengembangan keterampilan.</li><li>Kesempatan jenjang karir yang jelas.</li></ul><h3>Cara Melamar</h3><ol><li>Siapkan dokumen berikut:<ul><li>Surat Lamaran Kerja.</li><li>Curriculum Vitae (CV).</li><li>Fotokopi Ijazah dan Transkrip Nilai.</li><li>Fotokopi KTP.</li><li>Pas foto 4x6 (2 lembar).</li></ul></li><li>Kirimkan berkas lamaran ke alamat:<br><strong>HRD PT Teknologi Maju Sejahtera</strong><br>Jl. Industri No. 10, Surabaya<br><strong>Atau melalui email</strong>: hrd@teknomaju.com (format PDF).</li></ol><h3>Batas Akhir Pendaftaran</h3><p>Lowongan ini ditutup pada tanggal <strong>15 Januari 2025</strong>.</p><h3>Informasi Tambahan</h3><p>Untuk informasi lebih lanjut, hubungi:</p><ul><li><strong>Telepon</strong>: (031) 123-4567</li><li><strong>WhatsApp</strong>: 0812-3456-7890</li></ul><p>Mari bergabung dan jadilah bagian dari tim yang profesional serta inovatif!</p>',
                'industry' => json_encode([
                    "programmer"
                ]),
                'show' => true,
                'user_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Lowongan Kerja PT Sentosa Nusantara Jaya',
                'slug' => 'lowongan-kerja-pt-sentosa-nusantara-jaya',
                'photo' => 'jobfairs/01JG58G1EHE08SNDS3KWACD555.png',
                'deadline' => '2025-01-18 14:30:00',
                'content' => '<p>PT Sentosa Nusantara Jaya, perusahaan yang bergerak di bidang <strong>produksi dan distribusi makanan ringan</strong>, membuka kesempatan kerja bagi lulusan SMK untuk posisi <strong>Operator Produksi dan Pengemasan</strong>. Kami mencari individu yang disiplin, tanggap, dan mampu bekerja dalam lingkungan pabrik.</p><p><strong>Lokasi Kerja</strong>:</p><ul><li>Pabrik Utama: Jl. Raya Industri No. 45, Ngawi.</li><li>Distribusi Cabang: Seluruh Jawa Timur.</li></ul><h3>Kualifikasi yang Dibutuhkan</h3><ul><li><strong>Pendidikan</strong>: Lulusan SMK jurusan Teknik Mesin, Teknik Elektronika, atau Agribisnis Hasil Pertanian.</li><li><strong>Keahlian</strong>:<ul><li>Mampu mengoperasikan mesin produksi sederhana.</li><li>Paham tentang proses pengemasan produk makanan.</li><li>Mampu bekerja di bawah tekanan dengan target yang telah ditentukan.</li></ul></li><li><strong>Usia</strong>: Maksimal 27 tahun.</li><li>Memiliki kondisi fisik yang sehat dan siap bekerja dalam sistem shift.</li></ul><h3>Tanggung Jawab</h3><ol><li>Mengoperasikan mesin produksi sesuai prosedur yang ditetapkan.</li><li>Memastikan kualitas produk sesuai standar perusahaan.</li><li>Melakukan pengepakan dan pengemasan produk secara efisien.</li><li>Melaporkan kondisi mesin dan produksi kepada supervisor.</li></ol><h3>Fasilitas yang Didapatkan</h3><ul><li>Gaji pokok sesuai UMK Kabupaten Ngawi.</li><li>Tunjangan shift dan lembur.</li><li>Seragam kerja.</li><li>Asuransi kesehatan dan ketenagakerjaan.</li><li>Bonus produksi jika target tercapai.</li></ul><h3>Cara Melamar</h3><ol><li>Siapkan dokumen berikut:<ul><li>Surat Lamaran Kerja.</li><li>Curriculum Vitae (CV).</li><li>Fotokopi Ijazah dan Transkrip Nilai.</li><li>Fotokopi KTP.</li><li>Surat Keterangan Sehat dari puskesmas atau rumah sakit.</li><li>Pas foto 3x4 (2 lembar).</li></ul></li><li>Kirimkan berkas lamaran ke alamat:<br><strong>HRD PT Sentosa Nusantara Jaya</strong><br>Jl. Raya Industri No. 45, Ngawi<br><strong>Atau melalui email</strong>: hrd@sentosanusantara.co.id (format PDF).</li></ol><h3>Batas Akhir Pendaftaran</h3><p>Lowongan ini ditutup pada tanggal <strong>20 Januari 2025</strong>.</p><h3>Informasi Tambahan</h3><ul><li>Hanya pelamar yang memenuhi kualifikasi yang akan dipanggil untuk wawancara.</li><li>Pastikan nomor telepon yang tertera di CV aktif untuk mempermudah komunikasi.</li></ul><p><strong>Kontak</strong>:</p><ul><li>Telepon: (0351) 678-910</li><li>WhatsApp: 0813-4567-8910</li></ul><p>Bergabunglah bersama kami untuk membangun masa depan karier yang lebih cerah!</p>',
                'industry' => json_encode([
                    "Pabrik"
                ]),
                'show' => true,
                'user_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Lowongan Kerja PT Jaya Konstruksi Nusantara',
                'slug' => 'lowongan-kerja-pt-jaya-konstruksi-nusantara',
                'photo' => 'jobfairs/01JG58J8DGSRKKHCWRVFVZZTPD.png',
                'deadline' => '2025-01-02 14:30:00',
                'content' => '<p>PT Jaya Konstruksi Nusantara, perusahaan yang bergerak di bidang <strong>konstruksi dan pembangunan infrastruktur</strong>, mengundang lulusan SMK untuk bergabung sebagai <strong>Asisten Surveyor Lapangan</strong>. Kami mencari individu yang siap bekerja di lapangan dengan ketelitian dan integritas tinggi.</p><p><strong>Lokasi Kerja</strong>:<br>Proyek berlangsung di berbagai wilayah, dengan kantor pusat di Jl. Raya Pembangunan No. 88, Madiun.</p><h3>Kualifikasi yang Dibutuhkan</h3><ul><li><strong>Pendidikan</strong>: Lulusan SMK jurusan Teknik Bangunan, Teknik Geomatika, atau Teknik Sipil.</li><li><strong>Keahlian</strong>:<ul><li>Mampu menggunakan alat ukur seperti theodolite, total station, atau waterpass.</li><li>Menguasai dasar-dasar pemetaan dan pengukuran tanah.</li><li>Dapat membaca dan memahami gambar teknis.</li></ul></li><li><strong>Usia</strong>: Maksimal 25 tahun.</li><li>Siap bekerja di lapangan dengan jadwal yang fleksibel.</li></ul><h3>Tanggung Jawab</h3><ol><li>Membantu surveyor dalam melakukan pengukuran di lokasi proyek.</li><li>Mencatat dan mendokumentasikan hasil pengukuran secara detail.</li><li>Menyediakan data pengukuran untuk keperluan laporan teknis.</li><li>Bekerja sama dengan tim untuk memastikan proyek berjalan sesuai rencana.</li></ol><h3>Fasilitas yang Didapatkan</h3><ul><li>Gaji pokok sesuai UMK setempat.</li><li>Tunjangan lapangan.</li><li>Transportasi selama di lokasi proyek.</li><li>Asuransi kesehatan dan kecelakaan kerja.</li><li>Kesempatan mendapatkan pelatihan teknis tambahan.</li></ul><h3>Cara Melamar</h3><ol><li>Siapkan dokumen berikut:<ul><li>Surat Lamaran Kerja.</li><li>Curriculum Vitae (CV).</li><li>Fotokopi Ijazah dan Transkrip Nilai.</li><li>Fotokopi KTP.</li><li>Surat Keterangan Sehat dari puskesmas atau rumah sakit.</li><li>Pas foto 4x6 (2 lembar).</li></ul></li><li>Kirimkan berkas lamaran ke alamat:<br><strong>HRD PT Jaya Konstruksi Nusantara</strong><br>Jl. Raya Pembangunan No. 88, Madiun<br><strong>Atau melalui email</strong>: hrd@jayakonstruksi.co.id (format PDF).</li></ol><h3>Batas Akhir Pendaftaran</h3><p>Lamaran diterima paling lambat tanggal <strong>25 Januari 2025</strong>.</p><h3>Informasi Tambahan</h3><ul><li>Kandidat terpilih akan menjalani pelatihan kerja sebelum ditempatkan di proyek.</li><li>Pastikan nomor telepon dan email yang tertera pada CV aktif.</li></ul><p><strong>Kontak</strong>:</p><ul><li>Telepon: (0351) 123-456</li><li>WhatsApp: 0812-3456-7890</li></ul><p>Bersama kami, bangun karier yang kokoh dan masa depan yang gemilang!</p>',
                'industry' => json_encode([
                    "Sipil"
                ]),
                'show' => true,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Bergabunglah Bersama PT Cahaya Bersih Sejahtera sebagai Staf Kebersihan Industri',
                'slug' => 'bergabunglah-bersama-pt-cahaya-bersih-sejahtera-sebagai-staf-kebersihan-industri',
                'photo' => 'jobfairs/01JG58MKVG7WNC7794ZYM9EZVZ.jpg',
                'deadline' => '2025-01-31 14:30:00',
                'content' => '<p>PT Cahaya Bersih Sejahtera, perusahaan terkemuka dalam jasa <strong>kebersihan dan pengelolaan limbah industri</strong>, membuka lowongan untuk posisi <strong>Staf Kebersihan Industri</strong>. Kami mencari lulusan SMK yang tangguh, disiplin, dan memiliki perhatian terhadap detail.</p><p><strong>Lokasi Kerja</strong>:<br>Pabrik dan fasilitas industri yang bekerja sama di area Ngawi dan sekitarnya.</p><h3>Kualifikasi yang Dibutuhkan</h3><ul><li><strong>Pendidikan</strong>: Lulusan SMK jurusan Teknik Lingkungan, Teknik Mesin, atau relevan.</li><li><strong>Keahlian</strong>:<ul><li>Mampu menggunakan peralatan kebersihan industri.</li><li>Mengetahui dasar pengelolaan limbah sederhana (diutamakan).</li><li>Mampu bekerja dalam tim.</li></ul></li><li><strong>Usia</strong>: Maksimal 28 tahun.</li><li>Fisik sehat dan siap bekerja dalam lingkungan pabrik.</li></ul><h3>Tanggung Jawab</h3><ol><li>Melakukan pembersihan fasilitas sesuai standar perusahaan.</li><li>Mengelola dan memproses limbah sesuai dengan SOP.</li><li>Melaporkan kondisi fasilitas dan alat kebersihan kepada supervisor.</li><li>Menjaga efisiensi waktu dalam menyelesaikan tugas.</li></ol><h3>Fasilitas yang Didapatkan</h3><ul><li>Gaji pokok sesuai UMK.</li><li>Seragam kerja dan alat pelindung diri (APD).</li><li>Tunjangan kesehatan.</li><li>Bonus performa kerja.</li></ul><h3>Cara Melamar</h3><ol><li>Siapkan dokumen berikut:<ul><li>Surat Lamaran Kerja.</li><li>Curriculum Vitae (CV).</li><li>Fotokopi Ijazah dan Transkrip Nilai.</li><li>Fotokopi KTP.</li><li>Surat Keterangan Sehat dari puskesmas.</li><li>Pas foto 4x6 (2 lembar).</li></ul></li><li>Kirimkan berkas lamaran ke alamat:<br><strong>HRD PT Cahaya Bersih Sejahtera</strong><br>Jl. Raya Industri No. 22, Ngawi<br><strong>Atau melalui email</strong>: hrd@cahaya-bersih.co.id (format PDF).</li></ol><h3>Batas Akhir Pendaftaran</h3><p>Lowongan ini ditutup pada tanggal <strong>30 Januari 2025</strong>.</p><h3>Informasi Tambahan</h3><ul><li>Pelamar yang lolos seleksi akan dihubungi untuk tahap wawancara dan tes kesehatan.</li><li>Informasi lebih lanjut dapat menghubungi:<ul><li><strong>Telepon</strong>: (0351) 456-789</li><li><strong>WhatsApp</strong>: 0812-9876-5432</li></ul></li></ul><p>Mari jadikan kebersihan sebagai awal dari keberhasilan!</p><p><strong>Catatan:</strong><br>Lowongan ini khusus diperuntukkan bagi lulusan SMKN 1 Kasreman yang siap bekerja dengan dedikasi tinggi.</p>',
                'industry' => json_encode([
                    "Prama"
                ]),
                'show' => true,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Kesempatan Karier di PT Prima Logistik Nusantara',
                'slug' => 'kesempatan-karier-di-pt-prima-logistik-nusantara',
                'photo' => 'jobfairs/01JG5WSCV1EWQZ218543ZV5B3N.jpg',
                'deadline' => '2025-02-15 14:30:00',
                'content' => '<p>PT Prima Logistik Nusantara, perusahaan yang bergerak di bidang <strong>logistik dan manajemen gudang</strong>, membuka lowongan kerja untuk posisi <strong>Staf Gudang dan Pengiriman</strong>. Kami mencari individu yang memiliki semangat kerja tinggi, teliti, dan mampu bekerja dalam tim.</p><p><strong>Lokasi Kerja</strong>:<br>Gudang utama di Jl. Raya Logistik No. 12, Caruban, dengan kemungkinan pengiriman ke berbagai daerah di Jawa Timur.</p><h3>Kualifikasi yang Dibutuhkan</h3><ul><li><strong>Pendidikan</strong>: Lulusan SMK jurusan Teknik Otomotif, Teknik Mesin, atau Bisnis Daring dan Pemasaran.</li><li><strong>Keahlian</strong>:<ul><li>Memahami prosedur dasar pengelolaan gudang.</li><li>Terampil dalam mengoperasikan kendaraan roda empat (SIM A diutamakan).</li><li>Mampu menggunakan aplikasi pengelolaan stok sederhana (diutamakan).</li></ul></li><li><strong>Usia</strong>: Maksimal 26 tahun.</li><li>Siap bekerja dalam sistem shift.</li></ul><h3>Tanggung Jawab</h3><ol><li>Mengelola penerimaan, penyimpanan, dan pengiriman barang.</li><li>Memastikan barang di gudang tersusun rapi dan sesuai data stok.</li><li>Melakukan pengecekan kondisi barang sebelum pengiriman.</li><li>Berkoordinasi dengan tim pengiriman untuk memastikan barang sampai tepat waktu.</li></ol><h3>Fasilitas yang Didapatkan</h3><ul><li>Gaji pokok sesuai UMK.</li><li>Insentif kerja dan bonus pengiriman.</li><li>Fasilitas makan siang.</li><li>Asuransi kesehatan dan ketenagakerjaan.</li></ul><h3>Cara Melamar</h3><ol><li>Siapkan dokumen berikut:<ul><li>Surat Lamaran Kerja.</li><li>Curriculum Vitae (CV).</li><li>Fotokopi Ijazah dan Transkrip Nilai.</li><li>Fotokopi KTP.</li><li>Fotokopi SIM (jika ada).</li><li>Pas foto 3x4 (2 lembar).</li></ul></li><li>Kirimkan berkas lamaran ke alamat:<br><strong>HRD PT Prima Logistik Nusantara</strong><br>Jl. Raya Logistik No. 12, Caruban<br><strong>Atau melalui email</strong>: hrd@prima-logistik.co.id (format PDF).</li></ol><h3>Batas Akhir Pendaftaran</h3><p>Lamaran diterima paling lambat tanggal <strong>31 Januari 2025</strong>.</p><h3>Informasi Tambahan</h3><ul><li>Kandidat yang lolos akan mengikuti pelatihan singkat sebelum mulai bekerja.</li><li>Pastikan informasi kontak di CV aktif untuk mempermudah proses seleksi.</li></ul><p><strong>Kontak</strong>:</p><ul><li>Telepon: (0351) 321-654</li><li>WhatsApp: 0812-9876-5432</li></ul><p>Bersama kami, wujudkan karier yang lebih terarah dan penuh peluang!</p><p><strong>Catatan:</strong><br>Lowongan ini ditujukan khusus untuk lulusan SMKN 1 Kasreman yang siap berkarier di bidang logistik dan pengelolaan gudang.</p>',
                'industry' => json_encode([
                    "Gudang"
                ]),
                'show' => true,
                'user_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('organizational_structures')->insert([
            [
                'name' => 'Sturktur Organisasi',
                'photo' => 'organizational-structure/organisasi-skanka.jpg',
                'description' => 'Struktur Organisasi SMKN 1 Kasreman merupakan gambaran susunan kepemimpinan dan pembagian peran di lingkungan sekolah yang menjadi dasar terciptanya tata kelola pendidikan yang efektif, profesional, dan berintegritas.'
            ],
            [
                'name' => 'Sturktur Komite Sekolah',
                'photo' => 'organizational-structure/komite-skanka.jpg',
                'description' => 'Struktur Komite Sekolah SMKN 1 Kasreman menunjukkan susunan keanggotaan yang mewakili peran serta orang tua, masyarakat, dan pihak sekolah dalam mendukung peningkatan mutu pendidikan secara transparan dan kolaboratif.'
            ],
        ]);
    }
}