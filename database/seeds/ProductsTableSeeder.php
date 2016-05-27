<?php

use Illuminate\Database\Seeder;

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
            DB::table('products')->insert([
                'category_id' => $faker->numberBetween(1,15),
                'user_id' => $faker->numberBetween(4,53),
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
				'created_at' => time(),
                'updated_at' => time(),

            ]);
        }
    }
}
