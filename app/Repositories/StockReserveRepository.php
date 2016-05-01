<?php

namespace App\Repositories;

use App\Erp\Stocks\StockReserve;
use InfyOm\Generator\Common\BaseRepository;

class StockReserveRepository extends BaseRepository
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
        return StockReserve::class;
    }
}
