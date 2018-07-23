<?php

use Carbon\Carbon;
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
			$type = $faker->randomElement(['P','M']);
			$product_id = $faker->numberBetween(1,50);
            DB::table('product_feedbacks')->insert([
                'user_id' => $faker->numberBetween(4,53),
				'product_id' => $product_id,
				'time' => $faker->dateTimeBetween('-10 days','-3 days')->getTimestamp(),
				'comment' => $faker->sentence(10),
				'type' => $type,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
            ]);

			if ($type == 'P') DB::table('products')->where('id', $product_id)->increment('plus_count', 1);
			else if ($type == 'M') DB::table('products')->where('id', $product_id)->increment('minus_count', 1);
		}
    }
}
