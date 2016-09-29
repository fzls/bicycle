<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        if (app()->environment('local')) {
            app()->register(\Iber\Generator\ModelGeneratorProvider::class);
            app()->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            app()->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
        $this->app->alias('bugsnag.logger', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.logger', \Psr\Log\LoggerInterface::class);
    }
}
