<?php

use Illuminate\Database\Seeder;
use App\User;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::find(1);
        $admin->attachRole('1');
        
        $manager = User::find(2);
        $manager->attachRole('2');
        
        $member = User::find(3);
        $member->attachRole('3');
        
		$limit = 54;
		for ($i = 4; $i < $limit; $i++) {
			$member = User::find($i);
        	$member->attachRole('3');
        }
    }
}
