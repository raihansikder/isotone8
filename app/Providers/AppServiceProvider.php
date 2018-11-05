<?php

namespace App\Providers;

use App\Basemodule;
use App\Module;
use App\Observers\BasemoduleObserver;
use App\Observers\ModuleObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); // Had to add this to resolve string length issue.
        //Module::observe(ModuleObserver::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
