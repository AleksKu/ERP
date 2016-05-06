<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StockReserveApiTest extends TestCase
{
    use MakeStockReserveTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateStockReserve()
    {
        $stockReserve = $this->fakeStockReserveData();
        $this->json('POST', '/api/v1/stockReserves', $stockReserve);

        $this->assertApiResponse($stockReserve);
    }

    /**
     * @test
     */
    public function testReadStockReserve()
    {
        $stockReserve = $this->makeStockReserve();
        $this->json('GET', '/api/v1/stockReserves/'.$stockReserve->id);

        $this->assertApiResponse($stockReserve->toArray());
    }

    /**
     * @test
     */
    public function testUpdateStockReserve()
    {
        $stockReserve = $this->makeStockReserve();
        $editedStockReserve = $this->fakeStockReserveData();

        $this->json('PUT', '/api/v1/stockReserves/'.$stockReserve->id, $editedStockReserve);

        $this->assertApiResponse($editedStockReserve);
    }

    /**
     * @test
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
