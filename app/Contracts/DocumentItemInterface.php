<?php

namespace Torg\Contracts;

/**
 *
 * Interface DocumentInterface
 * @package Torg\Contracts
 */
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Torg\Base\Warehouse;
use Torg\Catalog\Product;
use Torg\Stocks\Stock;

/**
 * Interface DocumentItemInterface
 * @package Torg\Contracts
 *
 * @property DocumentItemInterface $item
 * @property Product $product
 */
interface DocumentItemInterface
{

    /**
     * @return mixed
     */
    public function product();

    /**
     * Сток
     * @return mixed
     */
    public function stock();

    /**
     * Документ к которому относится данная строка
     * @return BelongsTo
     */
    public function document();

    /**
     * @param DocumentItemInterface $item
     *
     * @return mixed
     */
    public function populateByDocumentItem(DocumentItemInterface $item);

    /**
     * @return Product
     */
    public function getProduct();

    /**
     * @return Stock
     */
    public function getStock();

    /**
     * @return DocumentInterface
     */
    public function getDocument();

    /**
     * @return Warehouse
     */
    public function getWarehouse();

}