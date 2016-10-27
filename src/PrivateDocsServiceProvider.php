<?php

namespace JapSeyz\PrivateDocs;

use Illuminate\Support\ServiceProvider;
use JapSeyz\PrivateDocs\PrivateDocsCommand;

class PrivateDocsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/privatedocs.php' => config_path('private_docs.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->register(\Mpociot\ApiDoc\ApiDocGeneratorServiceProvider::class);

        $this->app['privatedocs.generate'] = $this->app->share(function () {
            return new PrivateDocsCommand();
        });

        $this->commands([
            'privatedocs.generate',
        ]);

        \Route::get('/dev/docs', ['middleware' => config('privatedocs.middleware')], function () {
            return \File::get(resource_path() . '/docs/index.html');
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/privatedocs.php', 'privatedocs');
    }
}
