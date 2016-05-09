<?php


namespace Torg\Erp\Contracts;


interface OrderableInterface
{
    public function getPrice();

    public function getCost();
    
    public function getSku();
    

    
}