<?php

namespace Torg\Base\Money;

class Currency
{
    /** @var string */
    private $name;

    /** @var array */
    private static $currencies;

    /**
     * @param string $name
     * @throws UnknownCurrencyException
     */
    public function __construct($name)
    {
        $currencies = static::getCurrencies();

        if (!array_key_exists($name, $currencies)) {
            throw new UnknownCurrencyException($name);
        }
        
        $this->name = $name;
    }

    /**
     * @return array
     */
    public static function getCurrencies()
    {
        if(!isset(static::$currencies)) {
            static::$currencies = require __DIR__.'/currencies.php';
        }

        return static::$currencies;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Currency $other
     * @return bool
     */
    public function equals(Currency $other)
    {
        return $this->name === $other->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
