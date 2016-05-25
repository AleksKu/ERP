<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Torg\Base\User;
use Torg\Base\Workspace\WorkspaceManager;

class WorkspaceTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @var WorkspaceManager
     */
    private $workspaceManager;

    public function setUp()
    {
        parent::setUp();
        $this->workspaceManager = App::make(Torg\Base\Workspace\WorkspaceManager::class);
    }

    public function testRestoreFromRequest()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $this->workspaceManager->init($user);
        $workspaceAccountId = $this->workspaceManager->current()->accountId;

        static::assertEquals($workspaceAccountId, $user->getAccount()->id);

    }
}
