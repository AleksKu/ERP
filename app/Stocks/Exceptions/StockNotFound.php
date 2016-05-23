<?php

namespace Torg\Stocks\Exceptions;

/**
 * Class StockNotFound
 *
 * @package Torg\Stocks\Exceptions
 */
class StockNotFound extends StockException
{
    /**
     * @var string
     */
    protected $message = 'Stock not found';
}
