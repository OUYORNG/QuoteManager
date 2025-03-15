<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => bcrypt('Password123!')
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('Admin@123')
            ],
        ]);
    }
}
