<?php

namespace Torg\Base\Repositories;

use InfyOm\Generator\Common\BaseRepository;
use Torg\Base\Store;

class StoreRepository extends BaseRepository
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
        return Store::class;
    }

}
