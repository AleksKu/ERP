<?php

use Faker\Factory as Faker;
use Torg\Stocks\Stock;
use Torg\Stocks\Repositories\StockRepository;

trait MakeStockTrait
{
    /**
     * Create fake instance of Stock and save it in database
     *
     * @param array $stockFields
     *
     * @return Stock
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function makeStock(array $stockFields = array())
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
    public function fakeStock(array $stockFields = array())
    {
        return new Stock($this->fakeStockData($stockFields));
    }

    /**
     * Get fake data of Stock
     *
     * @param array $stockFields
     *
     * @return array
     */
    public function fakeStockData(array $stockFields = array())
    {


        return factory(Stock::class)->make($stockFields)->toArray();


    }
}
