<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // root
        $root = User::create([
            'name' => 'root',
            'email' => 'root@unisharp.com',
            'password' => bcrypt('root')
        ]);

        // admin
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@unisharp.com',
            'password' => bcrypt('admin')
        ]);
    }
}