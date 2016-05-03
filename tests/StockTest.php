<?php

use App\Erp\Catalog\Product;
use App\Erp\Organizations\Warehouse;
use App\Erp\Stocks\Repositories\StockRepository;
use App\Erp\Stocks\Stock;
use App\Repositories\StockReserveRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StockTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @var StockRepository
     */
    protected $stockRepo;

    public function setUp()
    {
        parent::setUp();
        $this->stockRepo = App::make(StockRepository::class);
    }





}
