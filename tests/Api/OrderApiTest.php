<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderApiTest extends TestCase
{
    use MakeOrderTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateOrder()
    {
        $order = $this->fakeOrderData();
        $this->json('POST', '/api/v1/orders', $order);

        $this->assertApiResponse($order);
    }

    /**
     * @test
     */
    public function testReadOrder()
    {
        $order = $this->makeOrder();
        $this->json('GET', '/api/v1/orders/'.$order->id);

        $this->assertApiResponse($order->toArray());
    }

    /**
     * @test
     */
    public function testUpdateOrder()
    {
        $order = $this->makeOrder();
        $editedOrder = $this->fakeOrderData();

        $this->json('PUT', '/api/v1/orders/'.$order->id, $editedOrder);

        $this->assertApiResponse($editedOrder);
    }

    /**
     * @test
     */
    public function testDeleteOrder()
    {
        $order = $this->makeOrder();
        $this->json('DELETE', '/api/v1/orders/'.$order->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/orders/'.$order->id);

        $this->assertResponseStatus(404);
    }
}
