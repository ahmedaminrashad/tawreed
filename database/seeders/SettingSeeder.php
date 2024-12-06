<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emailSetting = Setting::updateOrCreate(
            [
                'key' => 'email',
                'group' => 'general',
            ],
            [
                'value' => 'ispark@mail.com'
            ]
        );
    }
}
