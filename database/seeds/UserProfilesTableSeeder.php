<?php

use Illuminate\Database\Seeder;

class UserProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		$faker = Faker\Factory::create();

        $limit = 54;

        for ($i = 4; $i < $limit; $i++) {
            DB::table('user_profiles')->insert([
				'user_id' => $i,
				'category_id' => $faker->numberBetween(1,15),
				'fullname' => $faker->name,
				'born' => $faker->dateTimeBetween('-30 years','-20 years')->getTimestamp(),
				'picture' => $faker->numberBetween(1,10).".jpg",
				'cover' => $faker->numberBetween(1,4).".jpg",
				'location' => $faker->city,
				'summary' => ucwords($faker->sentence(6)),
				'profile' => $faker->paragraph(12),
				'created_at' => time(),
				'updated_at' => time(),
			]);
        }

    }
}
