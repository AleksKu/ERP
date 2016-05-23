<?php

namespace Torg\Stocks;

use Illuminate\Database\Query\Builder;
use Torg\Catalog\Product;

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
 * @property-read \Torg\Stocks\StockReserve $document
 * @property-read \Torg\Stocks\Stock $stock
 * @mixin \Eloquent
 * @property integer $stock_reserve_id
 * @method static Builder|StockReserveItem whereId($value)
 * @method static Builder|StockReserveItem whereProductId($value)
 * @method static Builder|StockReserveItem whereStockId($value)
 * @method static Builder|StockReserveItem whereStockReserveId($value)
 * @method static Builder|StockReserveItem wherePrice($value)
 * @method static Builder|StockReserveItem whereQty($value)
 * @method static Builder|StockReserveItem whereWeight($value)
 * @method static Builder|StockReserveItem whereVolume($value)
 * @method static Builder|StockReserveItem whereCreatedAt($value)
 * @method static Builder|StockReserveItem whereUpdatedAt($value)
 * @method static Builder|StockReserveItem whereDeletedAt($value)
 */
class StockReserveItem extends StockDocumentItem
{

    /**
     * @var string
     */
    protected $table = 'stock_reserve_items';

    /**
     * @var array
     */
    protected $with = ['product'];

    /**
     * @var array
     */
    protected $touches = ['stock'];

    /**
     * @var
     */
    public static $documentInstance = StockReserve::class;

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
     *
     * @return $this
     * @throws \Torg\Stocks\Exceptions\StockException
     * @throws \InvalidArgumentException
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
     *
     * @return $this
     * @throws \Torg\Stocks\Exceptions\StockException
     * @throws \InvalidArgumentException
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
