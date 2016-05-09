<?php

namespace Torg\Repositories;

use Torg\Models\Store;
use InfyOm\Generator\Common\BaseRepository;

class StoreRepository extends BaseRepository
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
        return Store::class;
    }
}
