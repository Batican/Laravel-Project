<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::upsert([
            ['name' => 'Admin', 'detail' => 'This is admin role'],
            ['name' => 'Customer', 'detail' => 'This is customer role'],

        ], ['name'], ['detail']);

        Role::where('name', 'Admin')->first()->permissions()->attach(Permission::pluck('id')->toArray());
        Role::where('name', 'Customer')->first()->permissions()->attach(Permission::where('slug', 'view-products')->pluck('id')->toArray());
    }
}
