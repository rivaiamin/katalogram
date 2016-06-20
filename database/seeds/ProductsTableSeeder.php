<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create();

        $limit = 50;

        for ($i = 0; $i < $limit; $i++) {
			$category_id = $faker->numberBetween(1,15);
			$user_id = $faker->numberBetween(4,53);
            DB::table('products')->insert([
                'category_id' => $category_id,
                'user_id' => $user_id,
                'slug' => $faker->slug,
                'name' => ucwords($faker->catchPhrase),
                'logo' => $faker->numberBetween(1,10).".jpg",
                'picture' => $faker->numberBetween(1,4).".jpg",
				'quote' => ucwords($faker->sentence(6)),
                'desc' => $faker->paragraph(12),
                'data' => $faker->paragraph(12),
                'website' => $faker->domainName,
                'embed' => $faker->url,
                'is_release' => 1,
				'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

			DB::table('categories')->where('id', $category_id)->increment('product_count', 1);
			DB::table('users')->where('id', $user_id)->increment('product_count', 1, ['id' => $user_id]);
        }
    }
}
