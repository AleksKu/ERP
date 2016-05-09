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
    
    public function warehouse();

    public function items();

    /**
     * @return Company
     */
    public function getCompany();

    /**
     * @return Warehouse
     */
    public function getWarehouse();

    public function getItems();
    
    public function getId();
    
    

}