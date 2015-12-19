<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            ['id' => 1, 'category_name' => 'Penerbitan', 'category_desc' => 'Penerbitan dan Percetaan', 'category_icon' => 'percetakan.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'category_name' => 'TI', 'category_desc' => 'Teknologi Informasi', 'category_icon' => 'teknologi.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'category_name' => 'Permainan', 'category_desc' => 'Permainan Interaktif', 'category_icon' => 'permainan.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'category_name' => 'Musik', 'category_desc' => 'Lagu, Lirik, Instrumen', 'category_icon' => 'musik.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'category_name' => 'Desain', 'category_desc' => 'Perancangan', 'category_icon' => 'desain.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'category_name' => 'Video', 'category_desc' => 'Film, Video & Fotografi', 'category_icon' => 'filmvideo.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'category_name' => 'Kerajinan', 'category_desc' => 'Kerajinan Tangan', 'category_icon' => 'kerajinan.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'category_name' => 'Seni Rupa', 'category_desc' => 'Illustrasi, Desain Grafis', 'category_icon' => 'senirupa.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'category_name' => 'Arsitektur', 'category_desc' => 'Arsitektur dan Bangunan', 'category_icon' => 'arsitek.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'category_name' => 'Kuliner', 'category_desc' => 'Makanan dan minuman', 'category_icon' => 'kuliner.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'category_name' => 'Mode', 'category_desc' => 'Pakaian dan Mode', 'category_icon' => 'mode.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'category_name' => 'Periklanan', 'category_desc' => 'Periklanan', 'category_icon' => 'iklan.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'category_name' => 'Pertunjukan', 'category_desc' => 'Seni Pertunjukan', 'category_icon' => 'pertunjukan.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'category_name' => 'Riset', 'category_desc' => 'Riset & Pengembangan', 'category_icon' => 'riset.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'category_name' => 'Penyiaran', 'category_desc' => 'Televisi & Radio', 'category_icon' => 'tvradio.png', 'category_parent' => NULL, 'category_type' => 'P', 'category_color' => NULL, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
