<?php

namespace Torg\Base\Repositories;

use InfyOm\Generator\Common\BaseRepository;
use Torg\Base\Account;

class AccountRepository extends BaseRepository
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
        return Account::class;
    }

}
