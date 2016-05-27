<?php

use Illuminate\Database\Seeder;

class ProductFeedbacksTableSeeder extends Seeder
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
            DB::table('product_feedbacks')->insert([
                'user_id' => $faker->numberBetween(4,53),
				'product_id' => $faker->numberBetween(1,15),
				'time' => $faker->dateTimeBetween('-10 days','-3 days')->getTimestamp(),
				'comment' => $faker->sentence(10),
				'type' => $faker->randomElement(['P','M']),
				'created_at' => time(),
				'updated_at' => time()
            ]);
        }
    }
}
