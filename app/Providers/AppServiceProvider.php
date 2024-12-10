<?php

namespace App\Providers;

use App\Contracts\CepInterface;
use App\Services\CepService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CepInterface::class, CepService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
