<?php

namespace App\Erp\Stocks\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class StockValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'product_id'=>'required',
            'warehouse_id'=>'required',
            'weight'=>'numeric',
            'available'=>'numeric',
            'reserved'=>'numeric',
            'min_qty'=>'numeric',
            'ideal_qty'=>'numeric',
            'volume'=>'numeric'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'warehouse_id'=>'same:warehouse_id'
        ],
   ];

}