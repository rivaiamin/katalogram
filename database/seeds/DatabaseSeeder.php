<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CategoriesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);

		$this->call(LinksTableSeeder::class);
		$this->call(TagsTableSeeder::class);
		$this->call(CriteriasTableSeeder::class);

		$this->call(ProductsTableSeeder::class);
		$this->call(ProductCriteriasTableSeeder::class);
		$this->call(ProductTagsTableSeeder::class);
		$this->call(ProductFeedbacksTableSeeder::class);

		$this->call(UserProfilesTableSeeder::class);
		$this->call(UserCollectsTableSeeder::class);
		$this->call(UserContactsTableSeeder::class);

        Model::reguard();
    }
}
