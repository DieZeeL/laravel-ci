<?php

namespace diezeel\CI;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class CIServiceProvider extends ServiceProvider
{

    protected const CONFIG = __DIR__ . '/../config/ci.php';

    /**
     * Booting the package.
     */
    public function boot()
    {

        $this->publishes([static::CONFIG => $this->app->configPath('ci.php')], 'ci');

//        $configPath = __DIR__ . '/../config';
//        $this->publishes([
//            $configPath . '/ci/autoload.php' => app_path('CI/config/autoload.php'),
//            $configPath . '/ci/config.php' => app_path('CI/config/config.php'),
//            $configPath . '/ci/constants.php' => app_path('CI/config/constants.php'),
//            $configPath . '/ci/doctypes.php' => app_path('CI/config/doctypes.php'),
//            $configPath . '/ci/foreign_chars.php' => app_path('CI/config/foreign_chars.php'),
//            $configPath . '/ci/hooks.php' => app_path('CI/config/hooks.php'),
//            $configPath . '/ci/memcached.php' => app_path('CI/config/memcached.php'),
//            $configPath . '/ci/migration.php' => app_path('CI/config/migration.php'),
//            $configPath . '/ci/mimes.php' => app_path('CI/config/mimes.php'),
//            $configPath . '/ci/profiler.php' => app_path('CI/config/profiler.php'),
//            $configPath . '/ci/routes.php' => app_path('CI/config/routes.php'),
//            $configPath . '/ci/smileys.php' => app_path('CI/config/smileys.php'),
//            $configPath . '/ci/user_agents.php' => app_path('CI/config/user_agents.php'),
//        ], 'config');

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
        $this->mergeConfigFrom(static::CONFIG, 'ci');
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
