<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StockReserveApiTest extends TestCase
{
    use MakeStockReserveTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * 
     */
    public function testCreateStockReserve()
    {
        $stockReserve = $this->fakeStockReserveData();
        $this->json('POST', '/api/v1/stockReserves', $stockReserve);

        $this->assertApiResponse($stockReserve);
    }

    /**
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testReadStockReserve()
    {
        $stockReserve = $this->makeStockReserve();
        $this->json('GET', '/api/v1/stockReserves/'.$stockReserve->id);

        $this->assertApiResponse($stockReserve->toArray());
    }

    /**
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testUpdateStockReserve()
    {
        /** @var \Torg\Stocks\StockReserve $stockReserve */
        $stockReserve = $this->makeStockReserve();
        $editedStockReserve = $this->fakeStockReserveData();

        $this->json('PUT', '/api/v1/stockReserves/'.$stockReserve->id, $editedStockReserve);

        $this->assertApiResponse($editedStockReserve);
    }

    /**
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testDeleteStockReserve()
    {
        $stockReserve = $this->makeStockReserve();
        $this->json('DELETE', '/api/v1/stockReserves/'.$stockReserve->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/stockReserves/'.$stockReserve->id);

        $this->assertResponseStatus(404);
    }
}
