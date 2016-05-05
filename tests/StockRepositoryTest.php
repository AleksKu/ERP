<?php

use App\Erp\Catalog\Product;
use App\Erp\Organizations\Warehouse;
use App\Erp\Stocks\Stock;
use App\Erp\Stocks\Repositories\StockRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Prettus\Validator\Exceptions\ValidatorException;

class StockRepositoryTest extends TestCase
{
    use MakeStockTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var StockRepository
     */
    protected $stockRepo;

    public function setUp()
    {
        parent::setUp();
        $this->stockRepo = App::make(StockRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateStock()
    {
        $stock = $this->fakeStockData();
        $createdStock = $this->stockRepo->create($stock);
        $createdStock = $createdStock->toArray();
        $this->assertArrayHasKey('id', $createdStock);
        $this->assertNotNull($createdStock['id'], 'Created Stock must have id specified');
        $this->assertNotNull(Stock::find($createdStock['id']), 'Stock with given id must be in DB');
        $this->assertModelData($stock, $createdStock);
    }

    /**
     * Запись для товара на одном складе должна быть одна
     */
    public function testCreateDuplicateStock()
    {
        $stock = factory(Stock::class)->create();

        $this->setExpectedException(\App\Erp\Stocks\Exceptions\StockException::class);

        $stock2 = factory(Stock::class)->create(['warehouse_id'=>$stock->warehouse_id, 'product_id'=>$stock->product_id]);
    }

    /**
     * @test
     */
    public function testCeateFromDocumentItem()
    {
        $warehouse = factory(Warehouse::class)->create();
        $product = factory(Product::class)->create();



        $stock = $this->stockRepo->createFromDocumentItem($item);

        $this->assertInstanceOf(Stock::class, $stock);
        $this->assertEquals($warehouse->id, $stock->warehouse_id);
        $this->assertEquals($product->id, $stock->product_id);

        $stock2 = $this->stockRepo->createFromDocumentItem($item);
        $this->assertEquals($stock->id, $stock2->id);



    }

    /**
     * @test read
     */
    public function testReadStock()
    {
        $stock = $this->makeStock();
        $dbStock = $this->stockRepo->find($stock->id);
        $dbStock = $dbStock->toArray();
        $this->assertModelData($stock->toArray(), $dbStock);
    }

    /**
     * @test update
     */
    public function testUpdateStock()
    {
        $stock = $this->makeStock();
        unset($stock['warehouse_id']);
        unset($stock['product_id']);
        $fakeStock = $this->fakeStockData();
        $updatedStock = $this->stockRepo->update($fakeStock, $stock->id);
        $this->assertModelData($fakeStock, $updatedStock->toArray());
        $dbStock = $this->stockRepo->find($stock->id);
        $this->assertModelData($fakeStock, $dbStock->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteStock()
    {
        $stock = $this->makeStock();
        $resp = $this->stockRepo->delete($stock->id);
        $this->assertTrue($resp);
        $this->assertNull(Stock::find($stock->id), 'Stock should not exist in DB');
    }

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
     * @return Stock
     */
    protected function createStock()
    {
        $stock = factory(Stock::class)->create(['qty' => 10, 'reserved' => 5, 'available' => 5]);
        return $stock;
    }

    /**
     * Изменить склад можно только в пределах организации
     */
    public function testChangeWarehouseWithoutOrganization()
    {
        $this->assertTrue(false);
    }

    public function testValidator()
    {
        $this->setExpectedException(ValidatorException::class);

        $stock = $this->stockRepo->create(['weight'=>2]);



    }

    public function testPresenter()
    {
        $warehouse = factory(Warehouse::class)->create();
        $product = factory(Product::class)->create();

        $stock = $this->stockRepo->setPresenter(\App\Erp\Stocks\Presenters\StockPresenter::class)
            ->create(['weight'=>2,'product_id'=>$product->id, 'warehouse_id'=>$warehouse->id]);

        //временно

        $this->assertEquals(40, $stock['data']['weight']);


    }


}
