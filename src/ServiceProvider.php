<?php

namespace Depiedra\LaravelSettings;

use Depiedra\LaravelSettings\Stores\SettingStore;
use Illuminate\Contracts\Support\DeferrableProvider;

class ServiceProvider extends \Illuminate\Support\ServiceProvider implements DeferrableProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('laravel-settings.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../migrations/2019_01_04_190000_create_settings_table.php' => database_path('migrations/' . date('Y_m_d_His') . '_create_settings_table.php'),
        ], 'migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SettingsManager::class, function ($app) {
            return new SettingsManager($app);
        });

        $this->app->bind(SettingStore::class, function ($app) {
            /** @var \Illuminate\Contracts\Foundation\Application $app */
            return $app->make(SettingsManager::class)->driver();
        });

        $this->app->alias(SettingStore::class, 'laravel-settings');

        $this->registerConfig();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            realpath(__DIR__ . '/../config/config.php'), 'laravel-settings'
        );
    }

    /**
     * Which IoC bindings the provider provides.
     *
     * @return array
     */
    public function provides()
    {
        return [
            SettingsManager::class, SettingStore::class, 'laravel-settings',
        ];
    }
}
