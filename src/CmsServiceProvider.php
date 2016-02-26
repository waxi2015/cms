<?php

namespace Waxis\Cms;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }

        $this->publishes([
            __DIR__.'/Controllers/AdminController.php' => app_path('Http/Controllers/AdminController.php'),
            __DIR__.'/Cms/Template/view/' => resource_path('views/admin'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
