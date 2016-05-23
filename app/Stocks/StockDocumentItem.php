<?php

namespace Torg\Stocks;

use Illuminate\Database\Eloquent\Model;
use Torg\Base\Warehouse;
use Torg\Catalog\Product;
use Torg\Contracts\DocumentItemInterface;

/**
 * Class StockDocumentItem
 *
 * @property float qty
 * @property StockDocument document
 * @property Product product
 * @property Stock stock
 * @package Torg\Stocks
 */
abstract class StockDocumentItem extends Model implements DocumentItemInterface
{

    /**
     * @var array
     */
    protected $with = ['product', 'document', 'stock'];

    /**
     * @var array
     */
    protected $touches = ['stock'];

    /**
     * @var string
     */
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }

    /**
     * сток
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * активация документа
     *
     * @return StockDocumentItem
     */
    public abstract function activate();

    /**
     * деактивация документа
     *
     * @return StockDocumentItem
     */
    public abstract function complete();

    /**
     * Заполняет поля на основание переданной строки документа
     *
     * @param DocumentItemInterface|StockDocumentItem $item
     *
     * @return mixed|void
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