<?php

namespace App\Erp\Stocks\Repositories;

use App\Erp\Catalog\Product;
use App\Erp\Organizations\Warehouse;
use App\Erp\Stocks\Stock;
use App\Erp\Stocks\Validators\StockValidator;
use InfyOm\Generator\Common\BaseRepository;

class StockRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return StockValidator::class;
    }

    /**
     * @return Stock
     */
    public function model()
    {
        return Stock::class;
    }

    /**
     * @param Warehouse $
     */
    public function findOrCreate(Warehouse $warehouse, Product $product)
    {
       $result = $this->model
           ->where('warehouse_id', '=', $warehouse->id)
           ->where('product_id', '=', $product->id)
           ->first();

        if($result instanceof Stock)
            return $this->parserResult($result);

            return  $this->create([
               'warehouse_id' =>  $warehouse->id,
                'product_id' => $product->id
            ]);

    }
}
