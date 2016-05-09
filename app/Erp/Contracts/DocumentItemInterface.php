<?php


namespace Torg\Erp\Contracts;


/**
 * 
 * Interface DocumentInterface
 * @package Torg\Erp\Contracts
 */
use Torg\Erp\Catalog\Product;
use Torg\Erp\Organizations\Warehouse;
use Torg\Erp\Stocks\Stock;

/**
 * Interface DocumentItemInterface
 * @package Torg\Erp\Contracts
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