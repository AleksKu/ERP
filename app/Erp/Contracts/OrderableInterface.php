<?php
/**
 * Created by PhpStorm.
 * User: newage
 * Date: 02.05.16
 * Time: 23:36
 */

namespace app\Erp\Contracts;


interface OrderableInterface
{
    public function getPrice();

    public function getCost();
    
    public function getSku();
    

    
}