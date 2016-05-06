<?php

use App\Erp\Catalog\Product;
use App\Erp\Organizations\Organization;
use App\Erp\Organizations\Warehouse;
use App\Erp\Sales\Order;
use App\Erp\Sales\OrderItem;
use App\Erp\Sales\Repositories\OrderRepository;
use App\Erp\Stocks\Exceptions\StockException;
use App\Erp\Stocks\Stock;
use App\Events\ReservebleItemCreating;
use App\Events\ReservebleItemSaving;
use App\Listeners\ItemReserveListener;
use App\Listeners\ItemStockCreateListener;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
            $this->assertArrayHasKey('id', $createdOrder);
            $this->assertNotNull($createdOrder['id'], 'Created Order must have id specified');
            $this->assertNotNull(Order::find($createdOrder['id']), 'Order with given id must be in DB');
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
            $this->assertTrue($resp);
            $this->assertNull(Order::find($order->id), 'Order should not exist in DB');
        }*/


    public function testCreateOrder()
    {
        $order = factory(Order::class)->create();

        $this->assertInstanceOf(Warehouse::class, $order->warehouse);
        $this->assertInstanceOf(Organization::class, $order->organization);

        $this->assertEquals(0, $order->weight);


    }

    /**
     * @test
     */
    public function testCreateOrderWithWarehouse()
    {


        $warehouse = factory(Warehouse::class)->create();
        $currentOrganization = $warehouse->organization;


        $order = factory(Order::class)->create(['warehouse_id' => $warehouse->id]);

        $this->assertInstanceOf(Warehouse::class, $order->warehouse);
        $this->assertInstanceOf(Organization::class, $order->organization);

        //когда устанавливаем склад для заказа, организация автоматоически должна устанавливаться из него
        $this->assertEquals($warehouse->id, $order->warehouse->id);
        $this->assertEquals($currentOrganization->id, $order->organization->id);


    }


    public function testChangeOrderWarehouse()
    {


        $warehouse = factory(Warehouse::class)->create();
        $currentOrganization = $warehouse->organization;


        $order = factory(Order::class)->create(['warehouse_id' => $warehouse->id]);
        $this->assertEquals($warehouse->id, $order->getWarehouse()->id);
        $this->assertEquals($currentOrganization->id, $order->getOrganization()->id);

        $warehouse2 = factory(Warehouse::class)->create(["organization_id" => $currentOrganization->id]);

        $order->warehouse()->associate($warehouse2);
        $order->save();
        $this->assertEquals($warehouse2->id, $order->getWarehouse()->id);
        $this->assertEquals($currentOrganization->id, $order->getOrganization()->id);


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
        $this->assertInstanceOf(Stock::class, $orderItem->stock);
        $this->assertEquals($orderItem->product->id, $product->id);
        $this->assertEquals($orderItem->stock->product->id, $product->id);

        $orderItem2 = factory(OrderItem::class)->make();
        $orderItem2->product()->associate($product);
        $orderItem2->document()->associate($order);
        $orderItem2->save();


        $this->assertEquals($orderItem->stock->id, $orderItem2->stock->id);
        $this->assertEquals($orderItem2->product->id, $product->id);
        $this->assertEquals($orderItem2->stock->product->id, $product->id);


        $product2 = factory(Product::class)->create();

        $orderItem3 = factory(OrderItem::class)->make();
        $orderItem3->product()->associate($product2);
        $orderItem3->document()->associate($order);
        $orderItem3->save();

        $this->assertNotEquals($orderItem->stock->id, $orderItem3->stock->id);
        $this->assertEquals($orderItem3->product->id, $product2->id);
        $this->assertEquals($orderItem3->stock->product->id, $product2->id);


    }


    public function testCalculateTotalsOrderItem()
    {
        $order = factory(Order::class)->create();

        $product = factory(Product::class)->create(['weight' => 10]);


        $orderItem = factory(OrderItem::class)->create(['order_id' => $order->id]);


        $this->assertEquals($orderItem->document->id, $order->id);

        $orderItem->product()->associate($product);

        $orderItem->price = 1000;
        $orderItem->qty = 5;

        $orderItem->save();

        $this->assertEquals($orderItem->total, 5000);

        $orderItem->total = 4000;
        $orderItem->price = 1000;
        $orderItem->qty = 3;
        $orderItem->save();
        $this->assertEquals($orderItem->total, 4000);
    }

    public function testAddItemToOrder()
    {
        /**
         * @var Order
         */
        $order = factory(Order::class)->create();
        $product = factory(Product::class)->create();

        $orderItem = factory(OrderItem::class)->make();
        $orderItem->product()->associate($product);
        
        $order->add($orderItem);
        $this->assertEquals($order->items->count(), 1);
        
        $orderItem2 = factory(OrderItem::class)->make();
        $orderItem2->product()->associate($product);
        $order->add($orderItem2);
        $this->assertEquals($order->items->count(), 2);

        

    }
}