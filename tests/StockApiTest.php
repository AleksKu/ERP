<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StockApiTest extends TestCase
{
    use MakeStockTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateStock()
    {
        $stock = $this->fakeStockData();
        $this->json('POST', '/api/v1/stocks', $stock);

        $this->assertApiResponse($stock);
    }

    /**
     * @test
     */
    public function testReadStock()
    {
        $stock = $this->makeStock();
        $this->json('GET', '/api/v1/stocks/'.$stock->id);

        $this->assertApiResponse($stock->toArray());
    }

    /**
     * @test
     */
    public function testUpdateStock()
    {
        $stock = $this->makeStock();
        $editedStock = $this->fakeStockData();

        $this->json('PUT', '/api/v1/stocks/'.$stock->id, $editedStock);

        $this->assertApiResponse($editedStock);
    }

    /**
     * @test
     */
    public function testDeleteStock()
    {
        $stock = $this->makeStock();
        $this->json('DELETE', '/api/v1/stocks/'.$stock->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/stocks/'.$stock->id);

        $this->assertResponseStatus(404);
    }
}
