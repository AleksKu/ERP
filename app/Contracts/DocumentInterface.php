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
    
    public function store();

    public function items();

    /**
     * @return Company
     */
    public function getCompany();

    /**
     * @return Warehouse
     */
    public function getWarehouse();

    public function getStore();

    public function getItems();
    
    public function getId();
    
    

}