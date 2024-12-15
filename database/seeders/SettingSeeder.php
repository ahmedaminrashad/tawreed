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
        Setting::updateOrCreate(
            [
                'key' => 'email',
                'group' => 'general',
            ],
            [
                'value' => 'info@quotech.com'
            ]
        );

        Setting::updateOrCreate(
            [
                'key' => 'phone',
                'group' => 'general',
            ],
            [
                'value' => '19888'
            ]
        );

        Setting::updateOrCreate(
            [
                'key' => 'facebook_link',
                'group' => 'general',
            ],
            [
                'value' => 'https://www.facebook.com/'
            ]
        );

        Setting::updateOrCreate(
            [
                'key' => 'instagram_link',
                'group' => 'general',
            ],
            [
                'value' => 'https://www.instagram.com/'
            ]
        );

        Setting::updateOrCreate(
            [
                'key' => 'twitter_link',
                'group' => 'general',
            ],
            [
                'value' => 'https://x.com/'
            ]
        );

        Setting::updateOrCreate(
            [
                'key' => 'linkedin_link',
                'group' => 'general',
            ],
            [
                'value' => 'https://www.linkedin.com/'
            ]
        );

        Setting::updateOrCreate(
            [
                'key' => 'review',
                'group' => 'general',
            ],
            [
                'value' => 1
            ]
        );

        Setting::updateOrCreate(
            [
                'key' => 'vat',
                'group' => 'general',
            ],
            [
                'value' => 14
            ]
        );

        Setting::updateOrCreate(
            [
                'key' => 'commission',
                'group' => 'general',
            ],
            [
                'value' => 10
            ]
        );
    }
}
