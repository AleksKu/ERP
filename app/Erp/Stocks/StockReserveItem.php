<?php

namespace App\Erp\Stocks;


use Illuminate\Database\Eloquent\Model;

use App\Erp\Catalog\Product;
use App\Erp\Organizations\Organization as Organization;
use App\Erp\Organizations\Warehouse;

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
