<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        // Share settings globally to all views
        View::composer('*', function ($view) {
            $settings = Setting::first() ?? new Setting([
                'school_name' => 'PAUD Damhil UNG',
                'welcome_text' => 'Selamat Datang di',
                'sub_text' => 'Membentuk generasi emas yang cerdas, ceria, dan berakhlak mulia',
                'contact_phone' => '08123456789',
                'contact_address' => 'Jl. Jend. Sudirman No. 1, Kota Gorontalo'
            ]);
            $view->with('settings', $settings);
        });
    }
}
