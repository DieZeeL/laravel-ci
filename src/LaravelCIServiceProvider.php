<?php

namespace diezeel\CI;

use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Providers\BootstrapServiceProvider;
use Nwidart\Modules\Providers\ConsoleServiceProvider;
use Nwidart\Modules\Providers\ContractsServiceProvider;

abstract class LaravelCIServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config';
        $this->publishes([
            $configPath.'/autoload.php' => config_path('ci/autoload.php'),
            $configPath.'/config.php' => config_path('ci/config.php'),
            $configPath.'/constants.php' => config_path('ci/constants.php'),
            $configPath.'/doctypes.php' => config_path('ci/doctypes.php'),
            $configPath.'/foreign_chars.php' => config_path('ci/foreign_chars.php'),
            $configPath.'/hooks.php' => config_path('ci/hooks.php'),
            $configPath.'/memcached.php' => config_path('ci/memcached.php'),
            $configPath.'/migration.php' => config_path('ci/migration.php'),
            $configPath.'/mimes.php' => config_path('ci/mimes.php'),
            $configPath.'/profiler.php' => config_path('ci/profiler.php'),
            $configPath.'/routes.php' => config_path('ci/routes.php'),
            $configPath.'/smileys.php' => config_path('ci/smileys.php'),
            $configPath.'/user_agents.php' => config_path('ci/user_agents.php'),
        ], 'config');
    }

    /**
     * Register all modules.
     */
    public function register()
    {
        $this->registerServices();
    }

    /**
     * Register all modules.
     */
//    protected function registerModules()
//    {
//        $this->app->register(BootstrapServiceProvider::class);
//    }

    /**
     * {@inheritdoc}
     */
    protected function registerServices()
    {
        $this->app->singleton(Contracts\CiInterface::class, function ($app) {
            $path = $app['config']->get('modules.paths.modules');

            return new BootstrapCI($app);
        });
        $this->app->alias(Contracts\CiInterface::class, 'ci');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Contracts\CiInterface::class, 'ci'];
    }

    /**
     * Register providers.
     */
    protected function registerProviders()
    {
//        $this->app->register(ConsoleServiceProvider::class);
//        $this->app->register(ContractsServiceProvider::class);
    }
}
