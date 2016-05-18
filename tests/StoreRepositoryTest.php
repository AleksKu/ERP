<?php

use Torg\Base\Store;
use Torg\Base\Repositories\StoreRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Torg\Base\Warehouse;

class StoreRepositoryTest extends TestCase
{
    use MakeStoreTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var StoreRepository
     */
    protected $storeRepo;

    public function setUp()
    {
        parent::setUp();
        $this->storeRepo = App::make(StoreRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateStore()
    {
        $store = $this->fakeStoreData();
        $createdStore = $this->storeRepo->create($store);
        $createdStore = $createdStore->toArray();
        $this->assertArrayHasKey('id', $createdStore);
        $this->assertNotNull($createdStore['id'], 'Created Store must have id specified');
        $this->assertNotNull(Store::find($createdStore['id']), 'Store with given id must be in DB');
        $this->assertModelData($store, $createdStore);
    }

    /**
     * @test read
     */
    public function testReadStore()
    {
        $store = $this->makeStore();
        $dbStore = $this->storeRepo->find($store->id);
        $dbStore = $dbStore->toArray();
        $this->assertModelData($store->toArray(), $dbStore);
    }

    /**
     * @test update
     */
    public function testUpdateStore()
    {
        $store = $this->makeStore();
        $fakeStore = $this->fakeStoreData();
        $updatedStore = $this->storeRepo->update($fakeStore, $store->id);
        $this->assertModelData($fakeStore, $updatedStore->toArray());
        $dbStore = $this->storeRepo->find($store->id);
        $this->assertModelData($fakeStore, $dbStore->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteStore()
    {
        $store = $this->makeStore();
        $resp = $this->storeRepo->delete($store->id);
        $this->assertTrue($resp);
        $this->assertNull(Store::find($store->id), 'Store should not exist in DB');
    }

    public function testAddWarehouse()
    {
        $warehouse = factory(Warehouse::class)->create();
        $salesWarehouse = factory(Warehouse::class)->create();
        $store = factory(Store::class)->create();
        $store->setDefaultWarehouse($warehouse);
        $store->setSalesWarehouse($salesWarehouse);

        $this->assertCount(2, $store->warehouses);
        $this->assertCount(1, $store->defaultWarehouse);
        $this->assertEquals($store->getDefaultWarehouse()->id, $warehouse->id);
        $this->assertEquals($store->getDefaultWarehouse()->pivot->type, Store::DEFAULT_WAREHOUSE_TYPE);
        $this->assertEquals($store->getSalesWarehouse()->id, $salesWarehouse->id);
        $this->assertEquals($store->getSalesWarehouse()->pivot->type, Store::SALES_WAREHOUSE_TYPE);

        $warehouse2 = factory(Warehouse::class)->create();
        $store->setDefaultWarehouse($warehouse2);
        $this->assertCount(2, $store->warehouses);
        $this->assertCount(1, $store->defaultWarehouse);
        $this->assertEquals($store->getDefaultWarehouse()->id, $warehouse2->id);

    }
}
