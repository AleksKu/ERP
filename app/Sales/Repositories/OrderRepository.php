<?php

namespace Torg\Sales\Repositories;

use Torg\Sales\Order;
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

    public function createItem(array $attributes)
    {

    }
}
