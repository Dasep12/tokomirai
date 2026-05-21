<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Import di bagian atas
use Illuminate\Support\Facades\View;
use App\Models\Setting;

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
        //
        Paginator::useBootstrapFive();
        \Carbon\Carbon::setLocale('id');
        \Illuminate\Support\Facades\Date::setLocale('id');

        $settings = Setting::all()->keyBy('key');

        View::share('global_settings', $settings);
    }
}
