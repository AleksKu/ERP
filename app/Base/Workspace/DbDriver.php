<?php


namespace Torg\Base\Workspace;


class DbDriver implements WorkspaceDriverInterface
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

}