<?php

use Torg\Stocks\StockReserve;
use Torg\Repositories\StockReserveRepository;
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
     *  create
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testCreateStockReserve()
    {
        $stockReserve = $this->fakeStockReserveData();
        $createdStockReserve = $this->stockReserveRepo->create($stockReserve);
        $createdStockReserve = $createdStockReserve->toArray();
        static::assertArrayHasKey('id', $createdStockReserve);
        static::assertNotNull($createdStockReserve['id'], 'Created StockReserve must have id specified');
        static::assertNotNull(StockReserve::find($createdStockReserve['id']), 'StockReserve with given id must be in DB');
        $this->assertModelData($stockReserve, $createdStockReserve);
    }

    /**
     *  read
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testReadStockReserve()
    {
        $stockReserve = $this->makeStockReserve();
        $dbStockReserve = $this->stockReserveRepo->find($stockReserve->id);
        $dbStockReserve = $dbStockReserve->toArray();
        $this->assertModelData($stockReserve->toArray(), $dbStockReserve);
    }

    /**
     *  update
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
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
     *  delete
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function testDeleteStockReserve()
    {
        $stockReserve = $this->makeStockReserve();
        $resp = $this->stockReserveRepo->delete($stockReserve->id);
        static::assertTrue($resp);
        static::assertNull(StockReserve::find($stockReserve->id), 'StockReserve should not exist in DB');
    }

    
    
    public function testSaveWarehouse()
    {
        $org1 = factory(\Torg\Base\Company::class)->create();

        $warehouse = factory(\Torg\Base\Warehouse::class)->create(['company_id'=>$org1->id]);
        $warehouse2 = factory(\Torg\Base\Warehouse::class)->create(['company_id'=>$org1->id]);
        $reserve = factory(StockReserve::class)->create(['warehouse_id'=>$warehouse->id]);

        static::assertInstanceOf(\Torg\Base\Warehouse::class, $reserve->warehouse);
        static::assertEquals($reserve->warehouse->id, $warehouse->id);

        $reserve->warehouse()->associate($warehouse2);
        static::assertEquals($reserve->warehouse->id, $warehouse2->id);



    }




    /**
     * Изменить склад можно только в пределах организации
     */
    public function testChangeWarehouseInvalidCompany()
    {
        $org1 = factory(\Torg\Base\Company::class)->create();
        $org2 = factory(\Torg\Base\Company::class)->create();

        $w1 = factory(\Torg\Base\Warehouse::class)->create(['company_id'=>$org1->id]);
        $w2 = factory(\Torg\Base\Warehouse::class)->create(['company_id'=>$org2->id]);

        $reserve = factory(StockReserve::class)->create(['warehouse_id'=>$w1->id]);

        $this->setExpectedException(\Torg\Stocks\Exceptions\StockException::class);

        $reserve->warehouse()->associate($w2);



    }
    
    
}
