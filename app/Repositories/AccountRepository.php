<?php

namespace Torg\Repositories;

use Torg\Models\Account;
use InfyOm\Generator\Common\BaseRepository;

class AccountRepository extends BaseRepository
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
        return Account::class;
    }
}
