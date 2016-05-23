<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StockApiTest extends TestCase
{
    use MakeStockTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * 
     */
    public function testCreateStock()
    {
        $stock = $this->fakeStockData();
        $this->json('POST', '/api/v1/stocks', $stock);

        $this->assertApiResponse($stock);
    }

    /**
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testReadStock()
    {
        $stock = $this->makeStock();
        $this->json('GET', '/api/v1/stocks/'.$stock->id);

        $this->assertApiResponse($stock->toArray());
    }

    /**
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testUpdateStock()
    {
        $stock = $this->makeStock();
        $editedStock = $this->fakeStockData();

        $this->json('PUT', '/api/v1/stocks/'.$stock->id, $editedStock);

        $this->assertApiResponse($editedStock);
    }

    /**
     * 
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
