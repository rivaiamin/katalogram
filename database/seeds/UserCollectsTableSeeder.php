<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserCollectsTableSeeder extends Seeder
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
			$product_id = $faker->numberBetween(1,50);
			$user_id = $faker->numberBetween(4,53);
            DB::table('user_collects')->insert([
                'product_id' => $product_id,
                'user_id' => $user_id,
                'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
            ]);

			DB::table('users')->where('id', $user_id)->increment('collect_count', 1);
			DB::table('products')->where('id', $product_id)->increment('collect_count');
        }
    }
}
