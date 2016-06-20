<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
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

		$faker = Faker\Factory::create();

        $limit = 50;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('users')->insert([
                'name' => $faker->userName,
                'email' => $faker->email,
				'picture' => $faker->numberBetween(1,10).".jpg",
				'password' => Hash::make('123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
