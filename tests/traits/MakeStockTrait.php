<?php

use Faker\Factory as Faker;
use App\Erp\Stocks\Stock;
use App\Erp\Stocks\Repositories\StockRepository;

trait MakeStockTrait
{
    /**
     * Create fake instance of Stock and save it in database
     *
     * @param array $stockFields
     * @return Stock
     */
    public function makeStock($stockFields = [])
    {
        /** @var StockRepository $stockRepo */
        $stockRepo = App::make(StockRepository::class);
        $theme = $this->fakeStockData($stockFields);
        return $stockRepo->create($theme);
    }

    /**
     * Get fake instance of Stock
     *
     * @param array $stockFields
     * @return Stock
     */
    public function fakeStock($stockFields = [])
    {
        return new Stock($this->fakeStockData($stockFields));
    }

    /**
     * Get fake data of Stock
     *
     * @param array $postFields
     * @return array
     */
    public function fakeStockData($stockFields = [])
    {


        return factory(Stock::class)->make($stockFields)->toArray();


    }
}
