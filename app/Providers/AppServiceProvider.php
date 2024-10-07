<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

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
        // Model::unguard(); // Disable fillable protection globally

        // Enable strict mode for mass assignment
        // Model::preventSilentlyDiscardingAttributes();
        // Model::preventSilentlyDiscardingAttributes($this->app->isLocal());

        /** @var \Illuminate\Foundation\Application $app */
        // $app = $this->app;
        // Model::preventSilentlyDiscardingAttributes(!$app->isProduction());
        // Model::preventLazyLoading(!$app->isProduction());

        Paginator::useBootstrapFive();
        // Paginator::useBootstrapFour();
    }
}
