<?php

use Torg\Erp\Catalog\Product;
use Torg\Erp\Contracts\DocumentItemInterface;
use Torg\Base\Warehouse;
use Torg\Erp\Stocks\Exceptions\StockException;
use Torg\Erp\Stocks\Presenters\StockPresenter;
use Torg\Erp\Stocks\Stock;
use Torg\Erp\Stocks\Repositories\StockRepository;
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

        $this->setExpectedException(StockException::class);

        $stock2 = $this->stockRepo->create(['warehouse_id'=>$stock->warehouse_id, 'product_id'=>$stock->product_id]);
    }

    /**
     * @test
     */
    public function testCreateFromDocumentItem()
    {
        $warehouse = factory(Warehouse::class)->create();
        $product = factory(Product::class)->create();

        $item = \Mockery::mock(DocumentItemInterface::class);
        $item->shouldReceive('getWarehouse')->times(4)->andReturn($warehouse);
        $item->shouldReceive('getProduct')->times(4)->andReturn($product);

        $stock = $this->stockRepo->createFromDocumentItem($item);

        $this->assertInstanceOf(Stock::class, $stock);
        $this->assertEquals($warehouse->id, $stock->warehouse->id);
        $this->assertEquals($product->id, $stock->product->id);

        $stock2 = $this->stockRepo->createFromDocumentItem($item);

        $item2 = \Mockery::mock(DocumentItemInterface::class);


        $item2->shouldReceive('getWarehouse')->times(2)->andReturn($warehouse);
        $item2->shouldReceive('getProduct')->times(2)->andReturn($product);
        $stock2 = $this->stockRepo->createFromDocumentItem($item2);

        $this->assertEquals($stock2->id, $stock->id);





    }

    public function testFindByDocumentItem()
    {



        $warehouse = factory(Warehouse::class)->create();
        $product = factory(Product::class)->create();



        $item = \Mockery::mock(DocumentItemInterface::class);
        $item->shouldReceive('getWarehouse')->times(1)->andReturn($warehouse);
        $item->shouldReceive('getProduct')->times(1)->andReturn($product);

        $stockExists = factory(Stock::class)->create(['warehouse_id'=>$warehouse->id,'product_id'=>$product->id]);


        $stock = $this->stockRepo->findByDocumentItem($item);

        $this->assertInstanceOf(Stock::class, $stock);
        $this->assertEquals($warehouse->id, $stock->warehouse->id);
        $this->assertEquals($product->id, $stock->product->id);
        $this->assertEquals($stockExists->id, $stock->id);
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

        $this->setExpectedException(StockException::class);

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

        $this->setExpectedException(StockException::class);
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

        $this->setExpectedException(StockException::class);

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
     * Изменить склад для созданного стока нельзя
     */
    public function testChangeWarehouse()
    {
        $stock = $this->createStock();
        $newWarehouse = factory(Warehouse::class)->create();
        $this->setExpectedException(ValidatorException::class);

        $stock->warehouse()->associate($newWarehouse);
        

    }

    public function testValidator()
    {
        $this->setExpectedException(ValidatorException::class);

        $this->stockRepo->create(['weight'=>'sdfsdf']);



    }

    /**
     *
     */
    public function testPresenter()
    {
        $warehouse = factory(Warehouse::class)->create();
        $product = factory(Product::class)->create();

        $stock = $this->stockRepo->setPresenter(StockPresenter::class)
            ->create(['weight'=>2,'product_id'=>$product->id, 'warehouse_id'=>$warehouse->id]);

        //временно

        $this->assertEquals(40, $stock['data']['weight']);


    }


}
