<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductCriteriasTableSeeder extends Seeder
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
            DB::table('product_criterias')->insert([
                ['product_id' => $i, 'criteria_id' => $faker->numberBetween(1,15), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['product_id' => $i, 'criteria_id' => $faker->numberBetween(16,30), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['product_id' => $i, 'criteria_id' => $faker->numberBetween(31,35), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['product_id' => $i, 'criteria_id' => $faker->numberBetween(36,50), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            ]);
        }
    }
}
