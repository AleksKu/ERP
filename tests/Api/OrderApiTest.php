<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Torg\Sales\Order;

class OrderApiTest extends TestCase
{
    use MakeOrderTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * 
     */
    public function testCreateOrder()
    {
        
        $order = $this->fakeOrderData();
        $this->json('POST', '/api/v1/orders', $order);

        $this->assertApiResponse($order);
    }

    /**
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testReadOrder()
    {
        /** @var Order $order */

        $order = $this->makeOrder();
        $this->json('GET', '/api/v1/orders/'.$order->id);

        $this->assertApiResponse($order->toArray());
    }

    /**
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testUpdateOrder()
    {
        /** @var Order $order */
        $order = $this->makeOrder();
        $editedOrder = $this->fakeOrderData();

        $this->json('PUT', '/api/v1/orders/'.$order->id, $editedOrder);

        $this->assertApiResponse($editedOrder);
    }

    /**
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testDeleteOrder()
    {
        /** @var Order $order */

        $order = $this->makeOrder();
        $this->json('DELETE', '/api/v1/orders/'.$order->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/orders/'.$order->id);

        $this->assertResponseStatus(404);
    }
}
