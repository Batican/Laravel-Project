<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::upsert([
            [
                'name' => 'John Doe',
                'email' =>  'john@test.com',
                'password' =>  bcrypt(123123),
                'role_id' => 1
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@test.com',
                'password' =>  bcrypt(123123),
                'role_id' => 2
            ]
        ], ['name', 'email'], ['password']);
    }
}