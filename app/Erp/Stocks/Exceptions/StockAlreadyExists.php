<?php


namespace App\Erp\Stocks\Exceptions;


class StockAlreadyExists extends StockException
{
    protected $message = 'Stock already exists';

}