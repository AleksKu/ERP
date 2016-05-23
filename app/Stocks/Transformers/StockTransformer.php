<?php

namespace Torg\Stocks\Transformers;

use League\Fractal\TransformerAbstract;
use Torg\Stocks\Stock;

class StockTransformer extends TransformerAbstract
{

    /**
     * Transform the \Stock entity
     *
     * @param Stock $model
     *
     * @return array
     */
    public function transform(Stock $model)
    {
        return [
            'weight' => $model->weight * 20,
        ];
    }
}
