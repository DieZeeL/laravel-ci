<?php

namespace diezeel\CI;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class CIServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {
        Response::macro('append', function ($content) {
            $this->content .= $content;
            return $this;
        });
    }

    /**
     * Register all modules.
     */
    public function register()
    {
        $this->registerConfig();
        require_once 'bootstrap.php';
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
