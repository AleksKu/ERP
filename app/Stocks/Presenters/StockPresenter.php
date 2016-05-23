<?php

namespace Torg\Stocks\Presenters;

use Prettus\Repository\Presenter\FractalPresenter;
use Torg\Stocks\Transformers\StockTransformer;

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
