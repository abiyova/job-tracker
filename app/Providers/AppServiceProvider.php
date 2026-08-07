<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        \Illuminate\Auth\Events\Login::class   => [\App\Listeners\LogSuccessfulLogin::class],
        \Illuminate\Auth\Events\Failed::class  => [\App\Listeners\LogFailedLogin::class],
        \Illuminate\Auth\Events\Logout::class  => [\App\Listeners\LogLogout::class],
    ];

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
    }
}
