<?php

namespace DevDojo\Database;

use DevDojo\Database\Components\Database;
use DevDojo\Database\Components\Tables;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class DatabaseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__, 'database');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('devdojo-database.php'),
            ], 'devdojo-database-config');
        }

        Livewire::component('devdojo.database', Database::class);
        Livewire::component('devdojo.tables', Tables::class);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'devdojo-database');
    }
}
