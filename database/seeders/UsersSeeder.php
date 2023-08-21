<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->insert([
            'name' => 'test',
            'email' => 'test@test.test',
            'password' => bcrypt('test123'),
            'is_admin' => true,
        ]);
    }
}
