<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobfairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
