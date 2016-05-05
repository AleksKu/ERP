<?php

namespace App\Listeners;

use App\Erp\Sales\Repositories\OrderRepository;
use App\Erp\Stocks\Repositories\StockRepository;
use App\Erp\Stocks\Stock;
use App\Events\ReservebleItemCreating;
use App\Events\ReservebleItemSaving;

use App\Repositories\StockReserveRepository;
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


        $stock = $this->stockRepository->createFromDocumentItem($item);
        $item->stock()->associate($stock);





    }
}
