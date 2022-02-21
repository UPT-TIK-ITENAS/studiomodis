<?php

namespace App\Providers;

use App\Http\Resources\RuanganCalendarResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
    }
}
