<?php

namespace diezeel\CI;

use Illuminate\Support\ServiceProvider;

class CIServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {
        $this->registerConfig();
    }

    /**
     * Register all modules.
     */
    public function register()
    {
        //
    }

    /**
     * Register package's namespaces.
     */
    protected function registerConfig()
    {
        $configPath = __DIR__ . '/../config/config.php';

        $this->mergeConfigFrom($configPath, 'ci');
        $this->publishes([
            $configPath => config_path('ci.php'),
        ], 'config');
    }
 
}
