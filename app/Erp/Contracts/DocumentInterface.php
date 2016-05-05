<?php


namespace App\Erp\Contracts;
use App\Erp\Organizations\Organization;
use App\Erp\Organizations\Warehouse;


/**
 *
 * Interface DocumentInterface
 * @package App\Erp\Contracts
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
    
    

}