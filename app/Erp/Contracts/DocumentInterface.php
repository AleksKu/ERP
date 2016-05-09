<?php


namespace Torg\Erp\Contracts;
use Torg\Base\Organization;
use Torg\Base\Warehouse;


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