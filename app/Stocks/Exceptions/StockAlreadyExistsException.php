<?php

namespace Torg\Stocks\Exceptions;

class StockAlreadyExistsException extends StockException
{
    /**
     * @var string
     */
    protected $message = 'Stock already exists';

    /**
     * @param string $message
     *
     * @return StockAlreadyExistsException
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}
