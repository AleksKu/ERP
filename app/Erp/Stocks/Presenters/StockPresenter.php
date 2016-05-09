<?php

namespace Torg\Erp\Stocks\Presenters;


use Torg\Erp\Stocks\Transformers\StockTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TestPresenter
 *
 * @package namespace Torg\Presenters;
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
