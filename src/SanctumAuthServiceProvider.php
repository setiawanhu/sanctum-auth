<?php

namespace Hu\Auth;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class SanctumAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind('sanctum-auth-model', function (Application $app) {
            return $app->make(config('auth.providers.users.model'));
        });
        $this->app->alias('sanctum-auth-model', AuthModel::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();

            $this->registerMigrations();

            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations')
            ], 'sanctum-auth');

            $this->publishSanctumFiles();
        }
    }

    /**
     * Register Auth's command.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        $this->commands([
            AuthCommand::class
        ]);
    }

    /**
     * Register Auth's migration files.
     *
     * @return void
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Calling artisan 'vendor:publish' command to publish Sanctum's configuration & migration files.
     *
     * @return void
     */
    protected function publishSanctumFiles(): void
    {
        Artisan::call('vendor:publish', [
            '--provider' => 'Laravel\Sanctum\SanctumServiceProvider'
        ]);
    }
}
