<?php

namespace AbnCms\RolesPermission;

use Aman5537jains\AbnCms\Lib\AbnCms;
use Aman5537jains\AbnCms\Lib\Theme\ScriptLoader;
use Illuminate\Support\ServiceProvider;

class RolesPermissionServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'AbnCmsCrud');

        // $this->publishes([
        //     __DIR__.'/resources/assets' => public_path('ReportBuilder'),
        // ], 'assets');
        // $this->loadMigrationsFrom(__DIR__.'/migrations');
        // $this->publishes([
        //     __DIR__.'/views' => base_path('resources/views/aman'),
        // ]);

    }




    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(
        //     __DIR__.'/abncms.php',
        //     'abncms'
        // );
    }
}
