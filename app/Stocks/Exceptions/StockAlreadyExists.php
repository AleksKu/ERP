<?php


namespace Torg\Stocks\Exceptions;


class StockAlreadyExists extends StockException
{
    protected $message = 'Stock already exists';

}