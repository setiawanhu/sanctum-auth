<?php

namespace Hu\Auth;

use Illuminate\Console\Command;

class AuthCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sanctum-auth:controller
                    { type=token : The auth type (token / spa) }
                    { --force : Overwrite existing controller by default }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating auth controller';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!collect([AuthModel::TOKEN, AuthModel::SPA])->contains($this->argument('type'))) {
            $this->error('Invalid controller type (must either token / spa).');
            return;
        }

        $controllerName = $this->argument('type') == AuthModel::TOKEN ?
            'TokenAuthController.php'
            :
            'SPAAuthController.php';

        $controller = app_path("Http/Controllers/Auth/$controllerName");

        $this->checkForMissingDirectory();

        if (file_exists($controller) && !$this->option('force')) {
            if ($this->confirm("The $controllerName file already exist. replace it?")) {
                $this->exportController($controllerName);
            }
        } else {
            $this->exportController($controllerName);
        }

        file_put_contents(
            base_path('routes/web.php'),
            $this->compileRoutesStub($controllerName),
            FILE_APPEND
        );

        $this->info('Controller & routing exported.');
    }

    /**
     * Checking for missing required directory.
     *
     * @return void
     */
    protected function checkForMissingDirectory()
    {
        if (!is_dir($directory = app_path('Http/Controllers/Auth'))) {
            mkdir($directory, 0755);
        }
    }

    /**
     * Export the Auth controller.
     *
     * @param string $controllerName
     */
    protected function exportController($controllerName)
    {
        copy(
            __DIR__ . "/Controllers/$controllerName",
            app_path("Http/Controllers/Auth/$controllerName")
        );
    }

    /**
     * @param string $controllerName
     * @return string
     */
    protected function compileRoutesStub($controllerName)
    {
        return str_replace(
            '{{controller}}',
            '\App\Http\Controllers\Auth\\' . str_replace('.php', '', $controllerName) . '::class',
            file_get_contents(__DIR__ . '/Stubs/routes.stub')
        );
    }
}
