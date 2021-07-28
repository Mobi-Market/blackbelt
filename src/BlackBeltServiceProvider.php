<?php

declare(strict_types=1);

namespace MobiMarket\BlackBelt;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use MobiMarket\BlackBelt\BlackBelt;

class BlackBeltServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @deprecated
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/blackbelt.php' => config_path('blackbelt.php'),
        ], 'blackbelt');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/blackbelt.php', 'blackbelt');

        $this->app->singleton(BlackBelt::class, function (Application $app) {
            $config = $app->make('config');

            return new BlackBelt(
                $config->get('blackbelt.client_id'),
                $config->get('blackbelt.client_secret'),
                $config->get('blackbelt.timeout')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [BlackBelt::class];
    }
}
