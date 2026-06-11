<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // NOVO

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
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // Faz a paginação usar a marcação .pagination/.page-item/.page-link,
        // que é estilizada no style.css (no padrão Sereno) — sem depender do
        // CSS do Bootstrap, que foi removido.
        Paginator::useBootstrapFive();
    }
}
