<?php

use Faker\Factory as Faker;
use Torg\Sales\Order;

use Torg\Sales\Repositories\OrderRepository;

trait MakeOrderTrait
{
    /**
     * Create fake instance of Order and save it in database
     *
     * @param array $orderFields
     *
     * @return Order
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function makeOrder(array $orderFields = array())
    {
        /** @var OrderRepository $orderRepo */
        $orderRepo = App::make(OrderRepository::class);
        $theme = $this->fakeOrderData($orderFields);
        return $orderRepo->create($theme);
    }

    /**
     * Get fake instance of Order
     *
     * @param array $orderFields
     * @return Order
     */
    public function fakeOrder(array $orderFields = array())
    {
        return new Order($this->fakeOrderData($orderFields));
    }

    /**
     * Get fake data of Order
     *
     * @param array $orderFields
     *
     * @return array
     */
    public function fakeOrderData(array $orderFields = array())
    {
        return factory(Order::class)->make($orderFields)->toArray();
    }
}
