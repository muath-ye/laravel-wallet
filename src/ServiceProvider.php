<?php

namespace Muathye\Wallet;

use Illuminate\Database\Eloquent\Relations\Relation;
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/wallet.php';
        $this->mergeConfigFrom($configPath, 'wallet');

    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/wallet.php';
        $migrationPath = __DIR__.'/../database/migrations/';
        $this->publishes(
            [$configPath => $this->getConfigPath()],
            'wallet-config'
        );

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes(
            [$migrationPath => database_path('migrations')],
            'wallet-migrations'
        );

        if (config()->has('wallet.wallet-morph-map-users')) {
            Relation::morphMap(
                config('wallet.wallet-morph-map-users')
            );
        }
        
        if (config()->has('wallet.wallet-morph-map-services')) {
            Relation::morphMap(
                config('wallet.wallet-morph-map-services')
            );
        }
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return config_path('wallet.php');
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('wallet.php')], 'config');
    }
}
