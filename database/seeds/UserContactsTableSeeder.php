<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 500;

        for ($i = 0; $i < $limit; $i++) {
			$user_id = $faker->numberBetween(4,53);
			$contact_id = $faker->numberBetween(4,53);
            DB::table('user_contacts')->insert([
                'user_id' => $user_id,
                'contact_id' => $contact_id,
                'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
            ]);

			DB::table('users')->where('id', $user_id)->increment('contact_count', 1);
			DB::table('users')->where('id', $contact_id)->increment('connect_count', 1);
        }
    }
}
