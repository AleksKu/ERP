<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StockTest extends TestCase
{

    use DatabaseTransactions;


    /**
     * тестируем резерв
     *
     * @return void
     */
    public function testReserveQty()
    {
        $stock = $this->createStock();

        $stock->reserveQty(1);

        $this->assertEquals(6, $stock->reserved);
        $this->assertEquals(4, $stock->available);
    }


    public function testFullReserveQty()
    {
        $stock = $this->createStock();

        $stock->reserveQty(4);
        $stock->reserveQty(1);

        $this->assertEquals(10, $stock->reserved);
        $this->assertEquals(0, $stock->available);
    }

    public function testOverReserveQty()
    {
        $stock = $this->createStock();

        $this->setExpectedException(\App\Erp\Stocks\Exceptions\StockException::class);

        $stock->reserveQty(6);


    }


    public function testRemoveReserveQty()
    {
        $stock = $this->createStock();


        $stock->removeReserveQty(4);

        $this->assertEquals(1, $stock->reserved);
        $this->assertEquals(9, $stock->available);


    }


    public function testRemoveOverReserveQty()
    {
        $stock = $this->createStock();

        $this->setExpectedException(\App\Erp\Stocks\Exceptions\StockException::class);
        $stock->removeReserveQty(8);


    }


    public function testCheckAvailable()
    {
        $stock = $this->createStock();

        $availible = $stock->checkAvailable(5);

        $this->assertTrue($availible);

        $availible = $stock->checkAvailable(6);

        $this->assertFalse($availible);


    }


    public function testSetQty()
    {
        $stock = $this->createStock();


        $stock->qty = 12;
        $this->assertEquals(5, $stock->reserved);
        $this->assertEquals(7, $stock->available);
        $this->assertEquals(12, $stock->qty);

    }

    public function testIncreaseQty()
    {
        $stock = $this->createStock();


        $stock->increaseQty(2);
        $this->assertEquals(5, $stock->reserved);
        $this->assertEquals(7, $stock->available);
        $this->assertEquals(12, $stock->qty);

    }

    /**
     * todo добавить проверку на списание свыше резервов
     */
    public function testDecreaseQty()
    {
        $stock = $this->createStock();


        $stock->decreaseQty(2);
        $this->assertEquals(5, $stock->reserved);
        $this->assertEquals(3, $stock->available);
        $this->assertEquals(8, $stock->qty);

        $this->setExpectedException(\App\Erp\Stocks\Exceptions\StockException::class);

        $stock->decreaseQty(9);

    }

    /**
     * @return \App\Erp\Stocks\Stock
     */
    protected function createStock()
    {
        $stock = factory(\App\Erp\Stocks\Stock::class)->create(['qty' => 10, 'reserved' => 5, 'available' => 5]);
        return $stock;
    }

    /**
     * Изменить склад можно только в пределах организации
     */
    public function testChangeWarehouseWithoutOrganization()
    {
        $this->assertTrue(false);
    }

}
