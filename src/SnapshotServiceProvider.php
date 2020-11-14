<?php

namespace Soved\Laravel\Snapshot;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;
use Soved\Laravel\Snapshot\Contracts\Snapshot as SnapshotContract;

class SnapshotServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
        $this->offerPublishing();

        $this->app->singleton(SnapshotContract::class, Snapshot::class);
    }

    /**
     * Setup the configuration.
     *
     * @return void
     */
    protected function configure()
    {
        $source = realpath($raw = __DIR__.'/../config/snapshot.php') ?: $raw;

        if ($this->app instanceof LumenApplication) {
            $this->app->configure('snapshot');
        }

        $this->mergeConfigFrom($source, 'snapshot');
    }

    /**
     * Setup the resource publishing groups.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/snapshot.php' => config_path('snapshot.php'),
            ], 'snapshot-config');
        }
    }
}
