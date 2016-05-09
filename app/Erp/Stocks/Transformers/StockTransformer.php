<?php

namespace Torg\Erp\Stocks\Transformers;

use League\Fractal\TransformerAbstract;
use Torg\Erp\Stocks\Stock;


class StockTransformer extends TransformerAbstract
{

    /**
     * Transform the \Stock entity
     * @param \Stock $model
     *
     * @return array
     */
    public function transform(Stock $model)
    {
        return [
            'weight'=>$model->weight*20
        ];
    }
}
