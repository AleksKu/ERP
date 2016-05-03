<?php

use Faker\Factory as Faker;
use App\Erp\Stocks\StockReserve;
use App\Repositories\StockReserveRepository;

trait MakeStockReserveTrait
{
    /**
     * Create fake instance of StockReserve and save it in database
     *
     * @param array $stockReserveFields
     * @return StockReserve
     */
    public function makeStockReserve($stockReserveFields = [])
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
    public function fakeStockReserve($stockReserveFields = [])
    {
        return new StockReserve($this->fakeStockReserveData($stockReserveFields));
    }

    /**
     * Get fake data of StockReserve
     *
     * @param array $postFields
     * @return array
     */
    public function fakeStockReserveData($stockReserveFields = [])
    {
        return factory(StockReserve::class)->make($stockReserveFields)->toArray();
    }
}
