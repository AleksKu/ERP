<?php

namespace App\Erp\Sales\Repositories;

use App\Erp\Sales\Order;
use InfyOm\Generator\Common\BaseRepository;

class OrderRepository extends BaseRepository
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
        return Order::class;
    }
}
