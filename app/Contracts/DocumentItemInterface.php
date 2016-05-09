<?php


namespace Torg\Contracts;


/**
 * 
 * Interface DocumentInterface
 * @package Torg\Contracts
 */
use Torg\Catalog\Product;
use Torg\Base\Warehouse;
use Torg\Stocks\Stock;

/**
 * Interface DocumentItemInterface
 * @package Torg\Contracts
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document();

    /**
     * @param DocumentItemInterface $item
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