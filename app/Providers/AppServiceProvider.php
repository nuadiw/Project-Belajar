<?php

namespace App\Providers;

use App\Models\Setting; // Import Model Setting
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Import Facade View
use Illuminate\Support\Facades\Schema; // Import Facade Schema
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();
        // Cek dulu apakah tabel 'settings' sudah ada di database
        // (Ini penting agar tidak error saat kamu pertama kali install/migrate)
        if (Schema::hasTable('settings')) {
            // Ambil semua setting dan jadikan array (key => value)
            $cms_settings = Setting::pluck('value', 'key')->all();

            // Share variabel ke seluruh view Blade
            View::share('cms_settings', $cms_settings);
        }
    }
}
