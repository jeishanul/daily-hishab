<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        view()->composer('*', function ($view) {

            $seederRun = true;
            if (User::count() > 0) {
                $seederRun = false;
            }

            $storageLink  = true;
            if (file_exists(public_path('storage'))) {
                $storageLink = false;
            }

            $view->with('seederRun', $seederRun);
            $view->with('storageLink', $storageLink);
        });
    }
}
