<?php

namespace Torg\Listeners;

use Torg\Erp\Sales\Repositories\OrderRepository;
use Torg\Erp\Stocks\Repositories\StockRepository;
use Torg\Erp\Stocks\Stock;
use Torg\Events\ReservebleItemCreating;
use Torg\Events\ReservebleItemSaving;

use Torg\Repositories\StockReserveRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ItemStockCreateListener
{

    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var StockRepository
     */
    private $stockRepository;

    /**
     * Create the event listener.
     *
     * @param OrderRepository $orderRepository
     * @param StockRepository $stockRepository
     */
    public function __construct(OrderRepository $orderRepository, StockRepository $stockRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->stockRepository = $stockRepository;
    }

    /**
     * Handle the event.
     *
     * @param  ReservebleItemCreating  $event
     * @return void
     */
    public function handle(ReservebleItemCreating $event)
    {
        

        $item = $event->item;





    }
}
