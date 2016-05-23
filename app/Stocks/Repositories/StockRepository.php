<?php

namespace Torg\Stocks\Repositories;

use InfyOm\Generator\Common\BaseRepository;
use Torg\Contracts\DocumentItemInterface;
use Torg\Stocks\Stock;
use Torg\Stocks\Validators\StockValidator;

class StockRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return StockValidator::class;
    }

    /**
     * @return Stock
     */
    public function model()
    {
        return Stock::class;
    }

    public function createFromProduct()
    {

    }

    /**
     * Создает сток на основании строки.
     * Если сток уже был создан, то возвращает его
     *
     * @param DocumentItemInterface $item
     *
     * @return Stock
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createFromDocumentItem(DocumentItemInterface $item)
    {
        $warehouse = $item->getWarehouse();
        $product = $item->getProduct();

        $result = $this->findByDocumentItem($item);

        if ($result instanceof Stock) {
            return $result;
        }

        return $this->create(
            [
                'warehouse_id' => $warehouse->id,
                'product_id' => $product->id,
            ]
        );
    }

    /**
     * Ищем Сток по строке документа
     *
     * @param DocumentItemInterface $item
     *
     * @return Stock
     */
    public function findByDocumentItem(DocumentItemInterface $item)
    {
        $warehouse = $item->getWarehouse();
        $product = $item->getProduct();
        $result = $this->model
            ->where('warehouse_id', '=', $warehouse->id)
            ->where('product_id', '=', $product->id)
            ->first();

        return $this->parserResult($result);
    }

}
