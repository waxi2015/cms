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
        if (! $this->app->routesAreCached() && config('cms.routes')) {
            require __DIR__.'/routes.php';
        }

        $publishes = [
            __DIR__.'/assets' => resource_path('assets/admin'),
            __DIR__.'/Descriptors/Form' => app_path('Descriptors/Form'),
            __DIR__.'/Descriptors/Image' => app_path('Descriptors/Image'),
            __DIR__.'/Converters' => app_path('Converters'),
            __DIR__.'/config/auth.php' => config_path('auth.php'),
            __DIR__.'/config/cms.php' => config_path('cms.php'),
            __DIR__.'/Controllers/AdminController.php' => app_path('Http/Controllers/AdminController.php'),
            __DIR__.'/Cms/Template/view/' => resource_path('views/admin'),
            __DIR__.'/Middleware/Authenticate.php' => app_path('Http/Middleware/Authenticate.php'),
            __DIR__.'/Middleware/VerifyCsrfToken.php' => app_path('Http/Middleware/VerifyCsrfToken.php'),
            __DIR__.'/migrations' => 'database/migrations',
            __DIR__.'/Admin.php' => app_path('Admin.php'),
            __DIR__.'/lang' => resource_path('lang'),
            __DIR__.'/public/uploads/images/admin' => public_path('uploads/images/admin'),
            __DIR__.'/resources/views/emails' => resource_path('views/emails'),
        ];

        if (!file_exists(app_path('Descriptors/Cms/Admin.php'))) {
            $publishes[__DIR__.'/Descriptors/Cms/Admin.php'] = app_path('Descriptors/Cms/Admin.php');
        }

        $this->publishes($publishes);
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
