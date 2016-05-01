<?php

use App\Erp\Stocks\StockReserve;
use App\Repositories\StockReserveRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StockReserveRepositoryTest extends TestCase
{
    use MakeStockReserveTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var StockReserveRepository
     */
    protected $stockReserveRepo;

    public function setUp()
    {
        parent::setUp();
        $this->stockReserveRepo = App::make(StockReserveRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateStockReserve()
    {
        $stockReserve = $this->fakeStockReserveData();
        $createdStockReserve = $this->stockReserveRepo->create($stockReserve);
        $createdStockReserve = $createdStockReserve->toArray();
        $this->assertArrayHasKey('id', $createdStockReserve);
        $this->assertNotNull($createdStockReserve['id'], 'Created StockReserve must have id specified');
        $this->assertNotNull(StockReserve::find($createdStockReserve['id']), 'StockReserve with given id must be in DB');
        $this->assertModelData($stockReserve, $createdStockReserve);
    }

    /**
     * @test read
     */
    public function testReadStockReserve()
    {
        $stockReserve = $this->makeStockReserve();
        $dbStockReserve = $this->stockReserveRepo->find($stockReserve->id);
        $dbStockReserve = $dbStockReserve->toArray();
        $this->assertModelData($stockReserve->toArray(), $dbStockReserve);
    }

    /**
     * @test update
     */
    public function testUpdateStockReserve()
    {
        $stockReserve = $this->makeStockReserve();
        $fakeStockReserve = $this->fakeStockReserveData();
        $updatedStockReserve = $this->stockReserveRepo->update($fakeStockReserve, $stockReserve->id);
        $this->assertModelData($fakeStockReserve, $updatedStockReserve->toArray());
        $dbStockReserve = $this->stockReserveRepo->find($stockReserve->id);
        $this->assertModelData($fakeStockReserve, $dbStockReserve->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteStockReserve()
    {
        $stockReserve = $this->makeStockReserve();
        $resp = $this->stockReserveRepo->delete($stockReserve->id);
        $this->assertTrue($resp);
        $this->assertNull(StockReserve::find($stockReserve->id), 'StockReserve should not exist in DB');
    }

    
    
    public function testSaveWarehouse()
    {
        $org1 = factory(\App\Erp\Organizations\Organization::class)->create();

        $warehouse = factory(\App\Erp\Organizations\Warehouse::class)->create(['organization_id'=>$org1->id]);
        $warehouse2 = factory(\App\Erp\Organizations\Warehouse::class)->create(['organization_id'=>$org1->id]);
        $reserve = factory(StockReserve::class)->create(['warehouse_id'=>$warehouse->id]);

        $this->assertInstanceOf(\App\Erp\Organizations\Warehouse::class, $reserve->warehouse);
        $this->assertEquals($reserve->warehouse->id, $warehouse->id);

        $reserve->warehouse()->associate($warehouse2);
        $this->assertEquals($reserve->warehouse->id, $warehouse2->id);



    }




    /**
     * Изменить склад можно только в пределах организации
     */
    public function testChangeWarehouseInvalidOrganization()
    {
        $org1 = factory(\App\Erp\Organizations\Organization::class)->create();
        $org2 = factory(\App\Erp\Organizations\Organization::class)->create();

        $w1 = factory(\App\Erp\Organizations\Warehouse::class)->create(['organization_id'=>$org1->id]);
        $w2 = factory(\App\Erp\Organizations\Warehouse::class)->create(['organization_id'=>$org2->id]);

        $reserve = factory(StockReserve::class)->create(['warehouse_id'=>$w1->id]);

        $this->setExpectedException(\App\Erp\Stocks\Exceptions\StockException::class);

        $reserve->warehouse()->associate($w2);



    }
    
    
}
