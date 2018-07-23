<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Site Administrator'; // optional
        $admin->description  = 'Mempunyai hak akses penuh pada website'; // optional
        $admin->save();
        
        $manager = new Role();
        $manager->name         = 'manager';
        $manager->display_name = 'Site Manager'; // optional
        $manager->description  = 'Mengatur konten'; // optional
        $manager->save();
        
        $member = new Role();
        $member->name         = 'member';
        $member->display_name = 'Site Member'; // optional
        $member->description  = 'Anggota, baik Kreator maupun Reviewer'; // optional
        $member->save();
    }
}
