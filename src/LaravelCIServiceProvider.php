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
            $configPath.'/autoload.php' => app_path('CI/config/autoload.php'),
            $configPath.'/config.php' => app_path('CI/config/config.php'),
            $configPath.'/constants.php' => app_path('CI/config/constants.php'),
            $configPath.'/doctypes.php' => app_path('CI/config/doctypes.php'),
            $configPath.'/foreign_chars.php' => app_path('CI/config/foreign_chars.php'),
            $configPath.'/hooks.php' => app_path('CI/config/hooks.php'),
            $configPath.'/memcached.php' => app_path('CI/config/memcached.php'),
            $configPath.'/migration.php' => app_path('CI/config/migration.php'),
            $configPath.'/mimes.php' => app_path('CI/config/mimes.php'),
            $configPath.'/profiler.php' => app_path('CI/config/profiler.php'),
            $configPath.'/routes.php' => app_path('CI/config/routes.php'),
            $configPath.'/smileys.php' => app_path('CI/config/smileys.php'),
            $configPath.'/user_agents.php' => app_path('CI/config/user_agents.php'),
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
//        $this->app->singleton(Contracts\CiInterface::class, function ($app) {
//            return new BootstrapCI($app);
//        });
//        $this->app->alias(Contracts\CiInterface::class, 'ci');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        //return [Contracts\CiInterface::class, 'ci'];
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
