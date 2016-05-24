<?php


use Torg\Base\Money\Currency;
use Torg\Base\Money\UnknownCurrencyException;

class CurrencyTest extends TestCase
{
    public function setUp()
    {
        $this->euro1 = new Currency('EUR');
        $this->euro2 = new Currency('EUR');
        $this->usd1 = new Currency('USD');
        $this->usd2 = new Currency('USD');
    }

    public function testDifferentInstancesAreEqual()
    {
        $this->assertTrue(
            $this->euro1->equals($this->euro2)
        );
        $this->assertTrue(
            $this->usd1->equals($this->usd2)
        );
    }

    public function testDifferentCurrenciesAreNotEqual()
    {
        $this->assertFalse(
            $this->euro1->equals($this->usd1)
        );
    }

    /**
     * @expectedException UnknownCurrencyException
     */
    public function testCantInstantiateUnknownCurrency()
    {
        new Currency('unknown');
    }
    
    public function testCastToString()
    {
        $name = 'CAD';
        $currency = new Currency($name);
        
        $this->assertSame((string)$currency, $name);
    }
}
