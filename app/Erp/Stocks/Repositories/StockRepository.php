<?php

namespace App\Erp\Stocks\Repositories;

use App\Erp\Catalog\Product;
use App\Erp\Organizations\Warehouse;
use App\Erp\Stocks\Stock;
use InfyOm\Generator\Common\BaseRepository;

class StockRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Stock::class;
    }

    /**
     * @param Warehouse $
     */
    public function findOrCreate(Warehouse $warehouse, Product $product)
    {
        
    }
}
