<?php

namespace Torg\Erp\Stocks;

use Torg\Erp\Contracts\DocumentItemInterface;
use Torg\Base\Warehouse;
use Illuminate\Database\Eloquent\Model;

use Torg\Erp\Catalog\Product;


abstract class StockDocumentItem extends Model implements DocumentItemInterface
{

    protected $with = ['product', 'document', 'stock'];

    protected $touches = ['stock'];

    public static $documentInstance;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function document()
    {
        return $this->belongsTo(static::$documentInstance);
    }


    /**
     * товар
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }


    /**
     * сток
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }



    /**
     * активация документа
     * @return StockDocumentItem
     */
    public abstract function activate();

    /**
     * деактивация документа
     * @return StockDocumentItem
     */
    public abstract function complete();


    /**
     * Заполняет поля на основание переданной строки документа
     * @param StockDocumentItem $item
     */

    public function populateByDocumentItem(DocumentItemInterface $item)
    {
        $this->product()->associate($item->product);
        $this->document()->associate($item->document);
        $this->qty = $item->qty;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return Stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @return StockDocument
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return Warehouse
     */
    public function getWarehouse()
    {
        return $this->getDocument()->getWarehouse();
    }
}