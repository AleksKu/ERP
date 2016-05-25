<?php

namespace Torg\Base\Workspace;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Torg\Base\Workspace\WorkspaceManager;

class WorkspaceMiddleware
{
    protected $auth;
    /**
     * @var WorkspaceManager
     */
    private $workspaceManager;



    public function __construct(Guard $auth, WorkspaceManager $workspaceManager)
    {
        $this->auth = $auth;
        $this->workspaceManager = $workspaceManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->workspaceManager->init($this->auth->user());

        return $next($request);
    }

    public function terminate(Request $request, Response $response)
    {
        $this->workspaceManager->store();
    }

}
