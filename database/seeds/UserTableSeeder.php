<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            ['level_id' => 1, 'name' => 'admin', 'email' => 'admin@gmail.com', 'password' => Hash::make('secret')],
            ['level_id' => 3, 'name' => 'agung', 'email' => 'agung69@gmail.com', 'password' => Hash::make('agung69')],
        ]);
    }
}
