<?php

namespace App\Erp\Stocks;


use App\Erp\Contracts\DocumentInterface;
use Illuminate\Database\Eloquent\Model;

use App\Erp\Catalog\Product;


/**
 * AQAL\Stocks\StockReserveItem
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $stock_id
 * @property integer $reserve_id
 * @property float $price
 * @property float $qty
 * @property float $weight
 * @property float $volume
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read Product $product
 * @property-read StockReserve $reserve
 * @property-read \App\Erp\Stocks\StockReserve $document
 * @property-read \App\Erp\Stocks\Stock $stock
 * @mixin \Eloquent
 * @property integer $stock_reserve_id
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Stocks\StockReserveItem whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Stocks\StockReserveItem whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Stocks\StockReserveItem whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Stocks\StockReserveItem whereStockReserveId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Stocks\StockReserveItem wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Stocks\StockReserveItem whereQty($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Stocks\StockReserveItem whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Stocks\StockReserveItem whereVolume($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Stocks\StockReserveItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Stocks\StockReserveItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Stocks\StockReserveItem whereDeletedAt($value)
 */
class StockReserveItem extends StockDocumentItem
{

    protected $table = 'stock_reserve_items';

    protected $with = ['product'];

    protected $touches = ['stock'];

    public static  $documentInstance = StockReserve::class;


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function document()
    {
        return $this->belongsTo(static::$documentInstance, 'stock_reserve_id');
    }




    /**
     * Проводит строки документа -
     * резервирует сток
     * @return $this
     */
    public function activate()
    {
        $stock = $this->stock;
        $qty = $this->qty;

        $stock->reserveQty($qty);
        $stock->save();

        return $this;

    }

    /**
     * Снимает резерв товара -
     * резервирует сток
     * @return $this
     */
    public function complete()
    {
        $stock = $this->stock;
        $qty = $this->qty;

        $stock->removeReserveQty($qty);
        $stock->save();

        return $this;

    }



}
