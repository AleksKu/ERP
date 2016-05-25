<?php

namespace Torg\Base\Workspace;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;



class WorkspaceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->middleware('workspace', WorkspaceMiddleware::class);
        $router->pushMiddlewareToGroup('web', 'workspace'); //может лучше в роутах напрямую указывать
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('workspace.driver.session', function ($app) {
            return new SessionDriver($app);
        });

        $this->app->singleton(WorkspaceManager::class, function ($app) {
            $driver = $app->make('workspace.driver.' . config('workspace.default'));
            return new WorkspaceManager($app, $driver);
        });
    }


}
