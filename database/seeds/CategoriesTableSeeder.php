<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Penerbitan & Percetakan', 'desc' => 'Suatu usaha atau kegiatan mengelola informasi dan daya imajinasi untuk membuat konten kreatif yang memiliki keunikan tertentu, dituangkan dalam bentuk tulisan, gambar dan/atau audio ataupun kombinasinya, diproduksi untuk dikonsumsi publik, melalui media cetak, media elektronik, ataupun media daring untuk mendapatkan nilai ekonomi, sosial ataupun seni dan budaya yang lebih tinggi', 'slug' => 'penerbitan', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Teknologi Informasi', 'desc' => 'Suatu proses menghasilkan ide atau gagasan agar menghasilkan suatu karya yang memiliki nilai tambah yaitu teknologi sebagai teknik dalam mengumpulkan, memproses, menganalisis, dan/atau menyebarkan informasi untuk memudahkan pengguna saling berinteraksi melalui jaringan komputer', 'slug' => 'teknologi', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Permainan Interaktif', 'desc' => 'Suatu media atau aktivitas yang memungkinkan tindakan bermain berumpan balik dan memiliki karakteristik setidaknya berupa tujuan (objective) dan aturan (rules)', 'slug' => 'permainan', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => 'Musik', 'desc' => 'Segala jenis usaha dan kegiatan kreatif  yang berkaitan dengan pendidikan, kreasi/komposisi, rekaman, promosi, distribusi, penjualan, dan pertunjukan karya seni musik', 'slug' => 'musik', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'name' => 'Desain', 'desc' => 'Proses pemecahan masalah objektif manusia dan lingkungan yang didasari kolaborasi ilmu dan kreativitas dengan menambahkan nilai-nilai termasuk nilai identitas budaya dan nilai tambah (added value) baik secara ekonomis, fungsional, sosial, dan estetika sehingga dapat memberikan solusi subjektif', 'slug' => 'desain', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'name' => 'Film, Animasi dan Fotografi', 'desc' => 'Video adalah sebuah aktivitas kreatif, berupa eksplorasi dan inovasi dalam cara merekam (capture) atau membuat gambar bergerak, yang ditampilkan melalui media presentasi, yang mampu memberikan karya gambar bergerak alternatif yang berdaya saing dan memberikan nilai tambah budaya, sosial, dan ekonomi', 'slug' => 'filmvideo', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'name' => 'Kerajinan', 'desc' => 'Bagian dari seni rupa terapan yang merupakan titik temu antara seni dan desain yang bersumber dari warisan tradisi atau ide kontemporer yang hasilnya dapat berupa karya seni, produk fungsional, benda hias dan dekoratif, serta dapat dikelompokkan berdasarkan material dan eksplorasi alat teknik yang digunakan, dan juga dari tematik produknya', 'slug' => 'kerajinan', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'name' => 'Seni Rupa', 'desc' => 'Penciptaan karya dan saling berbagi pengetahuan yang merupakan manifestasi intelektual dan keahlian kreatif, yang mendorong terjadinya perkembangan budaya dan perkembangan industri dengan nilai ekonomi untuk keberlanjutan ekosistemnya', 'slug' => 'senirupa', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'name' => 'Arsitektur', 'desc' => 'Wujud hasil penerapan pengetahuan, ilmu, teknologi, dan seni secara utuh dalam menggubah lingkungan binaan dan ruang, sebagai bagian dari kebudayaan dan peradaban manusia sehingga dapat menyatu dengan keseluruhan lingkungan ruang', 'slug' => 'arsitek', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'name' => 'Kuliner', 'desc' => 'Kegiatan persiapan, pengolahan, penyajian produk makanan dan minuman yang menjadikan unsur kreativitas, estetika, tradisi, dan/atau kearifan lokal; sebagai elemen terpenting dalam meningkatkan cita rasa dan nilai produk tersebut, untuk menarik daya beli dan memberikan pengalaman bagi konsumen', 'slug' => 'kuliner', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'name' => 'Mode', 'desc' => 'Suatu gaya hidup dalam berpenampilan yang mencerminkan identitas diri atau kelompok.. Mode bukan cuma ada pada pakaian. Mode ada di langit, ada di jalanan, mode berhubungan dengan ide-ide, bagaimana cara kita hidup, apa yang sedang hangat.', 'slug' => 'mode', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'name' => 'Periklanan', 'desc' => 'Bentuk komunikasi melalui media tentang produk dan/atau merek kepada khalayak sasarannya agar memberikan tanggapan sesuai tujuan pemrakarsa', 'slug' => 'iklan', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'name' => 'Seni Pertunjukan', 'desc' => 'Cabang kesenian yang melibatkan perancang, pekerja teknis dan penampil (performers), yang mengolah, mewujudkan dan menyampaikan suatu gagasan kepada penonton (audiences); baik dalam bentuk lisan, musik, tata rupa, ekspresi dan gerakan tubuh, atau tarian; yang terjadi secara langsung (live) di dalam ruang dan waktu yang sama, di sini dan kini (hic et nunc)', 'slug' => 'pertunjukan', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'name' => 'Penelitian & Pengembangan', 'desc' => 'Kegiatan sistematis untuk mengumpulkan, memanfaatkan serta mengolah ilmu pengetahuan dengan tujuan mengonfirmasi dan/atau merancang dan/atau mengembangkan suatu hal (objek penelitian) menjadi hal baru yang lebih baik dan inovatif yang dapat memenuhi kebutuhan pasar dan memberikan manfaat ekonomi', 'slug' => 'riset', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'name' => 'Televisi & Radio', 'desc' => 'Televisi adalah kegiatan kreatif yang meliputi proses pengemasan gagasan dan informasi dalam bentuk hiburan yang berkualitas kepada penikmatnya dalam format suara dan gambar yang disiarkan kepada publik dalam bentuk virtual secara teratur dan berkesinambungan. Radio adalah kegiatan kreatif yang meliputi proses pengemasan gagasan dan informasi secara berkualitas kepada penikmatnya dalam format suara yang disiarkan kepada publik dalam bentuk virtual secara teratur dan berkesinambungan', 'slug' => 'tvradio', 'parent_id' => NULL, 'type' => 'P', 'color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
