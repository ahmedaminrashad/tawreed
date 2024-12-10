<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::updateOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'list-dashboard',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'list-roles',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'create-roles',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'show-roles',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'edit-roles',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'list-admins',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'create-admins',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'show-admins',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'edit-admins',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'delete-admins',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'list-settings',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'show-settings',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'edit-settings',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'list-countries',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'create-countries',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'show-countries',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'edit-countries',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'delete-countries',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'list-cities',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'create-cities',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'show-cities',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'edit-cities',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'delete-cities',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'list-classifications',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'create-classifications',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'show-classifications',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'edit-classifications',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'delete-classifications',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'list-activity-classifications',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'create-activity-classifications',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'show-activity-classifications',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'edit-activity-classifications',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'delete-activity-classifications',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'list-units',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'create-units',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'show-units',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'edit-units',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'delete-units',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'list-cancellations',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'create-cancellations',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'show-cancellations',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'edit-cancellations',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'delete-cancellations',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'list-rejections',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'create-rejections',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'show-rejections',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'edit-rejections',
            'guard_name' => 'admin'
        ]);

        Permission::updateOrCreate([
            'name' => 'delete-rejections',
            'guard_name' => 'admin'
        ]);

        $permissions = Permission::get()->pluck('id')->toArray();

        $adminRole->syncPermissions($permissions);
    }
}
