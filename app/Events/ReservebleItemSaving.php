<?php

namespace Torg\Events;

use Torg\Stocks\Contracts\ReservebleItem;
use Torg\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReservebleItemSaving extends Event
{
    use SerializesModels;
    /**
     * @var ReservebleItem
     */
    public $item;

    /**
     * Create a new event instance.
     *
     * @param ReservebleItem $item
     */
    public function __construct(ReservebleItem $item)
    {
        //
        $this->item = $item;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
