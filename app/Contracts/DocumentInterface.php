<?php

namespace Torg\Contracts;

use Torg\Base\Company;
use Torg\Base\Warehouse;

/**
 *
 * Interface DocumentInterface
 * @package Torg\Contracts
 */
interface DocumentInterface
{

    /**
     * @return mixed
     */
    public function store();

    /**
     * @return mixed
     */
    public function items();

    /**
     * @return Company
     */
    public function getCompany();

    /**
     * @return Warehouse
     */
    public function getWarehouse();

    /**
     * @return mixed
     */
    public function getStore();

    /**
     * @return mixed
     */
    public function getItems();

    /**
     * @return mixed
     */
    public function getId();

}