<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::upsert([
            ['name' => 'Create users', 'description' => 'User with this role can add users', 'slug' => 'add-users'],
            ['name' => 'Edit users', 'description' => 'User with this role can edit users', 'slug' => 'edit-users'],
            ['name' => 'Delete users', 'description' => 'User with this role can delete users', 'slug' => 'delete-users'],
            ['name' => 'Assign users', 'description' => 'User with this role can assign roles for users', 'slug' => 'assign-users'],
            // ['name' => 'Create roles', 'description' => 'User with this role can add roles with its permissions', 'slug' => 'add-roles'],
            // ['name' => 'Edit roles', 'description' => 'User with this role can edit roles with its permissions', 'slug' => 'edit-roles'],
            // ['name' => 'Delete roles', 'description' => 'User with this role can delete roles with its permissions', 'slug' => 'delete-roles'],
            ['name' => 'Create products', 'description' => 'User with this role can add products with its permissions', 'slug' => 'add-products'],
            ['name' => 'Edit products', 'description' => 'User with this role can edit products with its permissions', 'slug' => 'edit-products'],
            ['name' => 'Delete products', 'description' => 'User with this role can delete products with its permissions', 'slug' => 'delete-products'],
            ['name' => 'View products', 'description' => 'User with this role can view products with its permissions', 'slug' => 'view-products'],
        ], ['name']);
    }
}
