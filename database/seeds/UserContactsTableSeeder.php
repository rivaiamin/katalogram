<?php

use Illuminate\Database\Seeder;

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
            DB::table('user_contacts')->insert([
                'user_id' => $faker->numberBetween(4,53),
                'contact_id' => $faker->numberBetween(4,53),
                'created_at' => time(),
				'updated_at' => time()
            ]);
        }
    }
}
