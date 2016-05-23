<?php

namespace Torg\Stocks\Exceptions;

class StockAlreadyExists extends StockException
{
    /**
     * @var string
     */
    protected $message = 'Stock already exists';

    /**
     * @param string $message
     *
     * @return StockAlreadyExists
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}
