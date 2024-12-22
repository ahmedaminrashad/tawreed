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
        $documentationAboutUS = Documentation::updateOrCreate(
            [
                'key' => 'about_us',
            ]
        );

        foreach (config('langs') as $locale => $name) {
            $documentationAboutUSTranslations[] = [
                'locale' => $locale,
                'page' => 'About Us',
            ];
        }

        $documentationAboutUS->translation()->delete();

        $documentationAboutUS->translation()->createMany($documentationAboutUSTranslations);

        $documentationPrivacyPolicy = Documentation::updateOrCreate(
            [
                'key' => 'privacy_policy',
            ]
        );

        foreach (config('langs') as $locale => $name) {
            $documentationPrivacyPolicyTranslations[] = [
                'locale' => $locale,
                'page' => 'Privacy Policy',
            ];
        }

        $documentationPrivacyPolicy->translation()->delete();

        $documentationPrivacyPolicy->translation()->createMany($documentationPrivacyPolicyTranslations);

        $documentationTermsConditions = Documentation::updateOrCreate(
            [
                'key' => 'terms_conditions',
            ]
        );

        foreach (config('langs') as $locale => $name) {
            $documentationTermsConditionsTranslations[] = [
                'locale' => $locale,
                'page' => 'Terms & Conditions',
            ];
        }

        $documentationTermsConditions->translation()->delete();

        $documentationTermsConditions->translation()->createMany($documentationTermsConditionsTranslations);
    }
}
