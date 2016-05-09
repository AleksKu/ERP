<?php


namespace Torg\Erp\Contracts;
use Torg\Erp\Organizations\Organization;
use Torg\Erp\Organizations\Warehouse;


/**
 *
 * Interface DocumentInterface
 * @package Torg\Erp\Contracts
 */
interface DocumentInterface
{
    
    public function warehouse();

    public function items();

    /**
     * @return Organization
     */
    public function getOrganization();

    /**
     * @return Warehouse
     */
    public function getWarehouse();

    public function getItems();
    
    public function getId();
    
    

}