<?php

namespace Torg\Base\Repositories;

use InfyOm\Generator\Common\BaseRepository;
use Torg\Base\Account;
use Torg\Base\Company;
use Torg\Base\Store;
use Torg\Base\Warehouse;

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

    /**
     * @param Account $account
     * @param string $title
     * @param string $code
     *
     * @return bool
     */
    public function createByAccount(Account $account, $title, $code)
    {
        $store = new Store();
        $store->setTitle($title);
        $store->setCode($code);
        $store->setAccount($account);

        return $store->save();

    }

    /**
     * @param Store $store
     * @param Company $company
     *
     * @return bool
     */
    public function updateCompany(Store $store, Company $company)
    {
        $store->setCompany($company);

        return $store->save();

    }

    /**
     * @param Store $store
     * @param Warehouse $warehouse
     * @param int $type
     *
     * @return bool
     */
    public function updateWarehouse(Store $store, Warehouse $warehouse, $type = Store::DEFAULT_WAREHOUSE_TYPE)
    {
        $store->setDefaultWarehouse($warehouse);

        return $store->save();

    }
}
