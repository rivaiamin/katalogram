<?php

use Illuminate\Database\Seeder;

class ProductTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 51;

        for ($i = 1; $i < $limit; $i++) {
            DB::table('product_tags')->insert([
                ['product_id' => $i, 'tag_id' => $faker->numberBetween(1,15), 'created_at' => time(), 'updated_at' => time()],
                ['product_id' => $i, 'tag_id' => $faker->numberBetween(16,30), 'created_at' => time(), 'updated_at' => time()],
                ['product_id' => $i, 'tag_id' => $faker->numberBetween(31,35), 'created_at' => time(), 'updated_at' => time()],
                ['product_id' => $i, 'tag_id' => $faker->numberBetween(36,50), 'created_at' => time(), 'updated_at' => time()]
            ]);
        }
    }
}
