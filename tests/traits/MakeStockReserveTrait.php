<?php

use Faker\Factory as Faker;
use Torg\Stocks\StockReserve;
use Torg\Repositories\StockReserveRepository;

trait MakeStockReserveTrait
{
    /**
     * Create fake instance of StockReserve and save it in database
     *
     * @param array $stockReserveFields
     *
     * @return StockReserve
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function makeStockReserve(array $stockReserveFields = [])
    {
        /** @var StockReserveRepository $stockReserveRepo */
        $stockReserveRepo = App::make(StockReserveRepository::class);
        $theme = $this->fakeStockReserveData($stockReserveFields);
        return $stockReserveRepo->create($theme);
    }

    /**
     * Get fake instance of StockReserve
     *
     * @param array $stockReserveFields
     * @return StockReserve
     */
    public function fakeStockReserve(array $stockReserveFields = [])
    {
        return new StockReserve($this->fakeStockReserveData($stockReserveFields));
    }

    /**
     * Get fake data of StockReserve
     *
     * @param array $stockReserveFields
     *
     * @return array
     */
    public function fakeStockReserveData(array $stockReserveFields = [])
    {
        return factory(StockReserve::class)->make($stockReserveFields)->toArray();
    }
}
