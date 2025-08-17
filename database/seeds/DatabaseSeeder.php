<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        factory(User::class, 1)->create([
            'username' => 'bob2501303',
            'email' => 'gdf000@hotmail.com',
            'password' => bcrypt('gamer333'),
            'active' => true,
            'admin' => true
        ]);
        factory(User::class, 1)->create([
            'username' => 'kazu',
            'email' => 'kazu@hotmail.com',
            'password' => bcrypt('gamer333'),
            'active' => true,
            'admin' => false
        ]);
        factory(User::class, 1)->create([
            'username' => 'motru',
            'email' => 'ampastre84@gmail.com',
            'password' => bcrypt('gamer333'),
            'active' => true,
            'admin' => false
        ]);

    }
}
