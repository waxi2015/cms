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
            __DIR__.'/assets' => resource_path('assets/admin'),
            __DIR__.'/Descriptors' => app_path('Descriptors'),
            __DIR__.'/config/auth.php' => config_path('auth.php'),
            __DIR__.'/config/cms.php' => config_path('cms.php'),
            __DIR__.'/Controllers/AdminController.php' => app_path('Http/Controllers/AdminController.php'),
            __DIR__.'/Cms/Template/view/' => resource_path('views/admin'),
            __DIR__.'/Middleware/Authenticate.php' => app_path('Http/Middleware/Authenticate.php'),
            __DIR__.'/migrations' => 'database/migrations',
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
