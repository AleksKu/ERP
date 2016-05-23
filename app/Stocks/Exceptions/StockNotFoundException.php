<?php

namespace Torg\Stocks\Exceptions;

/**
 * Class StockNotFound
 *
 * @package Torg\Stocks\Exceptions
 */
class StockNotFoundException extends StockException
{
    /**
     * @var string
     */
    protected $message = 'Stock not found';
}
