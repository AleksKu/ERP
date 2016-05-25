<?php

namespace Torg\Base\Workspace;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Torg\Base\User;


class WorkspaceManager
{

    /**
     * @var Workspace
     */
    private $workspace;
    /**
     * @var Application
     */
    private $app;
    /**
     * @var WorkspaceDriverInterface
     */
    private $driver;

    /**
     * WorkspaceManager constructor.
     * @param Application $app
     * @param WorkspaceDriverInterface $driver
     */
    public function __construct($app, WorkspaceDriverInterface $driver)
    {
        $this->workspace = new Workspace();
        $this->app = $app;
        $this->driver = $driver;

    }

    /**
     * @param User $user
     */
    public function init(User $user)
    {
        $this->initFromStore();
        $this->initFromRequest($user);
    }

    private function initFromStore()
    {
        $savedWorkspace = $this->driver->restore();
        if (null !== $savedWorkspace) {
            $this->workspace = $savedWorkspace;
        }
    }

    private function initFromRequest(User $user)
    {
        $this->workspace->accountId = $user->getAccount()->id;
    }


    public function store()
    {
        $this->driver->store($this->current());
    }


    public function current()
    {
        return $this->workspace;
    }

}