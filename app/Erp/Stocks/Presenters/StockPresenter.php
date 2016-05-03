<?php

namespace App\Erp\Stocks\Presenters;


use App\Erp\Stocks\Transformers\StockTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TestPresenter
 *
 * @package namespace App\Presenters;
 */
class StockPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StockTransformer();
    }
}
