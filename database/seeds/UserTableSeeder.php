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
            ['name' => 'admin', 'email' => 'admin@gmail.com', 'password' => Hash::make('secret')],
            ['name' => 'agung', 'email' => 'agung69@gmail.com', 'password' => Hash::make('agung69')],
            ['name' => 'karsakalana', 'email' => 'karsa.kalana@gmail.com', 'password' => Hash::make('karsakalana01!')],
        ]);
    }
}
