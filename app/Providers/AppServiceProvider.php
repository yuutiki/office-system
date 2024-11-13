<?php

namespace App\Providers;

use App\Observers\GlobalObserver;
use App\View\Components\Icon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;

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
        $this->registerPolicies();

        Blade::component('add-button', \App\View\Components\AddButton::class);
        Blade::component('icon', Icon::class);
    }
}
