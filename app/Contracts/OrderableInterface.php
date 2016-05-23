<?php

namespace Torg\Contracts;

interface OrderableInterface
{
    /**
     * @return mixed
     */
    public function getPrice();

    /**
     * @return mixed
     */
    public function getCost();

    /**
     * @return mixed
     */
    public function getSku();

}
