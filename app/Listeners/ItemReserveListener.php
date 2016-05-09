<?php

namespace Torg\Listeners;

use Torg\Sales\Repositories\OrderRepository;
use Torg\Stocks\Repositories\StockRepository;
use Torg\Events\ReservebleItemSaving;

use Torg\Repositories\StockReserveRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ItemReserveListener
{

    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var StockReserveRepository
     */
    private $reserveRepository;

    /**
     * Create the event listener.
     *
     * @param OrderRepository $orderRepository
     * @param StockReserveRepository $reserveRepository
     */
    public function __construct(OrderRepository $orderRepository, StockReserveRepository $reserveRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->reserveRepository = $reserveRepository;
    }

    /**
     * Handle the event.
     *
     * @param  ReservebleItemSaving  $event
     * @return void
     */
    public function handle(ReservebleItemSaving $event)
    {


        $item = $event->item;






    }
}
