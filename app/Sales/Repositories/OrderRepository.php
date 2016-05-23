<?php

namespace Torg\Sales\Repositories;

use InfyOm\Generator\Common\BaseRepository;
use Torg\Sales\Order;

class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Configure the Model
     *
     * @return string
     **/
    public function model()
    {
        return Order::class;
    }

    /**
     * @param array $attributes
     */
    public function createItem(array $attributes)
    {

    }
}
