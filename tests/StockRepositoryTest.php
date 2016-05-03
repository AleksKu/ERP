<?php

use App\Erp\Stocks\Stock;
use App\Erp\Stocks\Repositories\StockRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
}
