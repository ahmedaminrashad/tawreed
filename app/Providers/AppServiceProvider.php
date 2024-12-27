<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\Documentation;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        
        // share all Countries with all views
        view()->share('countries', Country::join('country_translations', 'countries.id', 'country_translations.country_id')
            ->select('countries.id as country_id', 'country_translations.name as country_name')
            ->where('country_translations.locale', 'ar')
            ->pluck('country_name', 'country_id')->toArray());

        // share Terms & Conditions with all views
        view()->share('terms_conditions', Documentation::where('key', 'terms_conditions')->first()->translate('ar')?->page);

        // share Privacy Policy with all views
        view()->share('privacy_policy', Documentation::where('key', 'privacy_policy')->first()->translate('ar')?->page);
    }
}
