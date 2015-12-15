<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_level')->insert([
            ['id' => 1, 'level_name' => 'admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'level_name' => 'moderator', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'level_name' => 'user', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
