<?php

namespace App\Providers;

use App\View\Composers\LinkComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
// use Livewire\Livewire;

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
        // View::composer('layouts.drawernavigation', LinkComposer::class);
    }
}
