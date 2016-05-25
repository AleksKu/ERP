<?php

namespace Torg\Base\Workspace;


interface WorkspaceDriverInterface
{

    public function store(Workspace $workspace);

    public function restore();

}