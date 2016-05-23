<?php

namespace Torg\Sales;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Torg\Base\Warehouse;
use Torg\Catalog\Product;
use Torg\Contracts\DocumentInterface;
use Torg\Contracts\DocumentItemInterface;
use Torg\Events\ReservebleItemCreating;
use Torg\Events\ReservebleItemSaving;
use Torg\Stocks\Contracts\ReservebleItem;
use Torg\Stocks\Repositories\StockRepository;
use Torg\Stocks\Stock;

/**
 * Torg\Sales\OrderItem
 *
 * @property-read \Torg\Catalog\Product $product
 * @property-read \Torg\Stocks\Stock $stock
 * @property-read \Torg\Sales\Order $document
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $product_id
 * @property integer $order_id
 * @property integer $stock_id
 * @property float $price
 * @property float $qty
 * @property float $total
 * @property float $weight
 * @property float $volume
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static Builder|OrderItem whereId($value)
 * @method static Builder|OrderItem whereProductId($value)
 * @method static Builder|OrderItem whereOrderId($value)
 * @method static Builder|OrderItem whereStockId($value)
 * @method static Builder|OrderItem wherePrice($value)
 * @method static Builder|OrderItem whereQty($value)
 * @method static Builder|OrderItem whereTotal($value)
 * @method static Builder|OrderItem whereWeight($value)
 * @method static Builder|OrderItem whereVolume($value)
 * @method static Builder|OrderItem whereCreatedAt($value)
 * @method static Builder|OrderItem whereUpdatedAt($value)
 * @method static Builder|OrderItem whereDeletedAt($value)
 * @property string $sku
 * @property float $base_price
 * @property float $base_cost
 * @property float $subtotal
 * @property float $discount
 * @method static Builder|OrderItem whereSku($value)
 * @method static Builder|OrderItem whereBasePrice($value)
 * @method static Builder|OrderItem whereBaseCost($value)
 * @method static Builder|OrderItem whereSubtotal($value)
 * @method static Builder|OrderItem whereDiscount($value)
 */
class OrderItem extends Model implements DocumentItemInterface, ReservebleItem
{

    /**
     * @var array
     */
    protected $with = ['document', 'product'];

    /**
     * @var array
     */
    protected $attributes = [
        'base_price' => 0,
        'base_cost' => 0,
        'total' => 0,
        'subtotal' => 0,
        'discount' => 0,
        'qty' => 0,
    ];

    /**
     * @var array
     */
    public $fillable = [
        'product_id',
        'order_id',
        'stock_id',
        'base_price',
        'base_cost',
        'qty',
        'subtotal',
        'discount',
        'total',
        'weight',
        'volume',
    ];

    /**
     * @var array
     */
    protected $touches = ['document'];

    public static function boot()
    {

        parent::boot();

        static::created(
            function (OrderItem $orderItem) {

                $orderItem->_createStock();

                event(new ReservebleItemCreating($orderItem));
            }
        );

        static::saved(
            function (OrderItem $orderItem) {

                event(new ReservebleItemSaving($orderItem));
            }
        );

        static::saving(
            function (OrderItem $orderItem) {

                $orderItem->calculateTotals();
            }
        );
    }

    public function _createStock()
    {

        $stock = App::make(StockRepository::class)->createFromDocumentItem($this);
        $this->stock()->associate($stock);
    }

    /**
     *
     */
    public function calculateTotals()
    {
        if (empty($this->attributes['total'])) {
            $this->subtotal = $this->base_price * $this->qty;
            $this->total = $this->subtotal;

        }

        if (!empty($this->attributes['discount'])) {
            $this->total = $this->subtotal + $this->discount;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * Документ к которому относится данная строка
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->document();
    }

    /**
     * @param DocumentItemInterface $item
     *
     * @return mixed
     */
    public function populateByDocumentItem(DocumentItemInterface $item)
    {
        // TODO: Implement populateByDocumentItem() method.
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
     * @return DocumentInterface
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
