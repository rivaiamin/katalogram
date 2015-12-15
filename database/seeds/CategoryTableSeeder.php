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
        ]);
    }
}
