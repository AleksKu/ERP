<?php


namespace Torg\Base\Workspace;


use Illuminate\Session\SessionManager;

class SessionDriver implements WorkspaceDriverInterface
{

    /**
     * @var SessionManager
     */
    private $session;

    public function __construct($app)
    {
        $this->session = $app->make('session');
    }

    public function store(Workspace $workspace)
    {
        $this->session->set('workspace', $workspace);
    }

    public function restore()
    {
        return \Session::get('workspace');
    }
}