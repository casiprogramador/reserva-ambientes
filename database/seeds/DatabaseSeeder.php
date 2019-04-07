<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Marcelo Choque',
            'email' => 'casiprogramador@gmail.com',
            'password' => bcrypt('59173527623'),
            'rol' => 'administrador',
        ]);
    }
}
