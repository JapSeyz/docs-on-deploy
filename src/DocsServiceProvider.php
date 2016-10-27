<?php

namespace JapSeyz\Docs;

use Illuminate\Support\ServiceProvider;
use JapSeyz\Docs\DocsCommand;

class DocsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/deploydocs.php' => config_path('deploydocs.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->register(\Mpociot\ApiDoc\ApiDocGeneratorServiceProvider::class);

        $this->app['docs.generate'] = $this->app->share(function () {
            return new DocsCommand();
        });

        $this->commands([
            'docs.generate',
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../config/deploydocs.php', 'deploydocs');
    }
}
