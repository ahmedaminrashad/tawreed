<?php

namespace Database\Seeders;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Admin::updateOrCreate(
            [
                'email' => 'superadmin@mail.com',
            ],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('123456'),
                'email_verified_at' => Carbon::now(),
            ]
        );

        $superadminRole = Role::find(1);

        $superadmin->assignRole($superadminRole);
    }
}
