<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Torg\Base\Company;
use Torg\Base\Store;
use Torg\Base\Warehouse;
use Torg\Catalog\Product;
use Torg\Events\ReservebleItemCreating;
use Torg\Events\ReservebleItemSaving;
use Torg\Sales\Order;
use Torg\Sales\OrderItem;
use Torg\Sales\Repositories\OrderRepository;
use Torg\Stocks\Exceptions\StockException;
use Torg\Stocks\Stock;

class OrderRepositoryTest extends TestCase
{
    use MakeOrderTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var OrderRepository
     */
    protected $orderRepo;

    public function setUp()
    {
        parent::setUp();
        $this->orderRepo = App::make(OrderRepository::class);
    }

    /*
        public function testCreateOrder()
        {
            $order = $this->fakeOrderData();
            $createdOrder = $this->orderRepo->create($order);
            $createdOrder = $createdOrder->toArray();
            static::assertArrayHasKey('id', $createdOrder);
            static::assertNotNull($createdOrder['id'], 'Created Order must have id specified');
            static::assertNotNull(Order::find($createdOrder['id']), 'Order with given id must be in DB');
            $this->assertModelData($order, $createdOrder);
        }
    
    
        public function testReadOrder()
        {
            $order = $this->makeOrder();
            $dbOrder = $this->orderRepo->find($order->id);
            $dbOrder = $dbOrder->toArray();
            $this->assertModelData($order->toArray(), $dbOrder);
        }
    
    
        public function testUpdateOrder()
        {
            $order = $this->makeOrder();
            $fakeOrder = $this->fakeOrderData();
            $updatedOrder = $this->orderRepo->update($fakeOrder, $order->id);
            $this->assertModelData($fakeOrder, $updatedOrder->toArray());
            $dbOrder = $this->orderRepo->find($order->id);
            $this->assertModelData($fakeOrder, $dbOrder->toArray());
        }
    
    
        public function testDeleteOrder()
        {
            $order = $this->makeOrder();
            $resp = $this->orderRepo->delete($order->id);
            static::assertTrue($resp);
            static::assertNull(Order::find($order->id), 'Order should not exist in DB');
        }*/

    public function testCreateOrder()
    {
        $order = factory(Order::class)->create();

        static::assertInstanceOf(Store::class, $order->getStore());
        static::assertInstanceOf(Company::class, $order->getCompany());

        static::assertEquals(0, $order->weight);

    }

    /**
     * 
     */
    public function testCreateOrderWithWarehouse()
    {

        $warehouse = factory(Warehouse::class)->create();
        $currentCompany = $warehouse->company;

        $order = factory(Order::class)->create(['warehouse_id' => $warehouse->id]);

        static::assertInstanceOf(Warehouse::class, $order->warehouse);
        static::assertInstanceOf(Company::class, $order->company);

        //когда устанавливаем склад для заказа, организация автоматически должна устанавливаться из него
        static::assertEquals($warehouse->id, $order->warehouse->id);
        static::assertEquals($currentCompany->id, $order->company->id);

    }

    public function testChangeOrderWarehouse()
    {

        $warehouse = factory(Warehouse::class)->create();
        $currentCompany = $warehouse->company;

        $order = factory(Order::class)->create(['warehouse_id' => $warehouse->id]);
        static::assertEquals($warehouse->id, $order->getWarehouse()->id);
        static::assertEquals($currentCompany->id, $order->getCompany()->id);

        $warehouse2 = factory(Warehouse::class)->create(['company_id' => $currentCompany->id]);

        $order->warehouse()->associate($warehouse2);
        $order->save();
        static::assertEquals($warehouse2->id, $order->getWarehouse()->id);
        static::assertEquals($currentCompany->id, $order->getCompany()->id);

        $warehouse3 = factory(Warehouse::class)->create();

        $this->setExpectedException(StockException::class);

        $order->warehouse()->associate($warehouse3);
        $order->save();

    }

    public function testCreateOrderItem()
    {

        /**
         * @var Order
         */
        $order = factory(Order::class)->create();
        $warehouse = $order->getWarehouse();
        $product = factory(Product::class)->create();

        $orderItem = factory(OrderItem::class)->make();

        $orderItem->document()->associate($order);
        $orderItem->product()->associate($product);

        $this->expectsEvents(ReservebleItemSaving::class);
        $this->expectsEvents(ReservebleItemCreating::class);

        //если total не установлен, то считаем автоматом
        $orderItem->save();

        //для OrderItem сток явно не установлен, но он должен автоматом установиться на основании
        //склада и товара
        static::assertInstanceOf(Stock::class, $orderItem->stock);
        static::assertEquals($orderItem->product->id, $product->id);
        static::assertEquals($orderItem->stock->product->id, $product->id);

        $orderItem2 = factory(OrderItem::class)->make();
        $orderItem2->product()->associate($product);
        $orderItem2->document()->associate($order);
        $orderItem2->save();

        static::assertEquals($orderItem->stock->id, $orderItem2->stock->id);
        static::assertEquals($orderItem2->product->id, $product->id);
        static::assertEquals($orderItem2->stock->product->id, $product->id);

        $product2 = factory(Product::class)->create();

        $orderItem3 = factory(OrderItem::class)->make();
        $orderItem3->product()->associate($product2);
        $orderItem3->document()->associate($order);
        $orderItem3->save();

        static::assertNotEquals($orderItem->stock->id, $orderItem3->stock->id);
        static::assertEquals($orderItem3->product->id, $product2->id);
        static::assertEquals($orderItem3->stock->product->id, $product2->id);

    }

    public function testCalculateTotalsOrderItem()
    {
        $order = factory(Order::class)->create();

        $product = factory(Product::class)->create(['weight' => 10]);

        $orderItem = factory(OrderItem::class)->create(['order_id' => $order->id]);

        static::assertEquals($orderItem->document->id, $order->id);

        $orderItem->product()->associate($product);

        $orderItem->price = 1000;
        $orderItem->qty = 5;

        $orderItem->save();

        static::assertEquals($orderItem->total, 5000);

        $orderItem->total = 4000;
        $orderItem->price = 1000;
        $orderItem->qty = 3;
        $orderItem->save();
        static::assertEquals($orderItem->total, 4000);
    }

    public function testAddItemToOrder()
    {
        /**
         * @var Order
         */
        $order = factory(Order::class)->create();
        $product = factory(Product::class)->create();

        $orderItem = factory(OrderItem::class)->make(['qty' => 1]);
        $orderItem->product()->associate($product);

        $order->add($orderItem);
        $order->save();
        static::assertEquals(1, $order->items->count());
        static::assertEquals(1, $order->items_count);
        static::assertEquals(1, $order->products_qty);

        $orderItem2 = factory(OrderItem::class)->make(['qty' => 2]);
        $orderItem2->product()->associate($product);
        $order->add($orderItem2);
        $order->save();

        static::assertEquals($order->items->count(), 2);
        static::assertEquals($order->order_item_count, 2);
        static::assertEquals($order->products_qty, 3);

    }
}