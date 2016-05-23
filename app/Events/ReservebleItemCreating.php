<?php

namespace Torg\Events;

use Illuminate\Queue\SerializesModels;
use Torg\Stocks\Contracts\ReservebleItemInterface;

class ReservebleItemCreating extends Event
{
    use SerializesModels;

    /**
     * @var ReservebleItemInterface
     */
    public $item;

    /**
     * Create a new event instance.
     *
     * @param ReservebleItemInterface $item
     */
    public function __construct(ReservebleItemInterface $item)
    {
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
