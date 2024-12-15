<?php

namespace Database\Seeders;

use App\Models\Documentation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Documentation::updateOrCreate(
            [
                'key' => 'about_us',
            ]
        );

        Documentation::updateOrCreate(
            [
                'key' => 'privacy_policy',
            ]
        );

        Documentation::updateOrCreate(
            [
                'key' => 'terms_conditions',
            ]
        );
    }
}
