<?php

namespace App\Providers;

use App\Http\Resources\RuanganCalendarResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        RuanganCalendarResource::withoutWrapping();
        Schema::defaultStringLength(191);
    }
}
