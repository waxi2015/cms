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
            __DIR__.'/Descriptors/Admin.php' => app_path('Descriptors/Cms/Admin.php'),
            __DIR__.'/config/cms.php' => config_path('cms.php'),
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
