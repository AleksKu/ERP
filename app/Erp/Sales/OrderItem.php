<?php

namespace App\Erp\Sales;

use App\Erp\Catalog\Product;
use App\Erp\Contracts\DocumentInterface;
use App\Erp\Contracts\DocumentItemInterface;
use App\Erp\Organizations\Warehouse;
use App\Erp\Stocks\Contracts\ReservebleItem;
use App\Erp\Stocks\Contracts\ShouldReserve;
use App\Erp\Stocks\Stock;
use App\Events\ReservebleItemCreating;
use App\Events\ReservebleItemSaving;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Erp\Sales\OrderItem
 *
 * @property-read \App\Erp\Catalog\Product $product
 * @property-read \App\Erp\Stocks\Stock $stock
 * @property-read \App\Erp\Sales\Order $document
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
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem whereStockId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem whereQty($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem whereVolume($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Sales\OrderItem whereDeletedAt($value)
 */
class OrderItem extends Model implements DocumentItemInterface, ReservebleItem
{



    protected $with = ['document', 'product'];

    public $fillable = [
        'product_id',
        'order_id',
        'stock_id',
        'price',
        'qty',
        'total',
        'weight',
        'volume'
    ];

    public static function boot()
    {

        parent::boot();

        static::created(function (OrderItem $orderItem) {
          
            event(new ReservebleItemCreating($orderItem));
        });

        static::saved(function (OrderItem $orderItem) {

            event(new ReservebleItemSaving($orderItem));
        });
    }

    
    
    public function calculateTotals()
    {
        
    }
    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * 
     * @return
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
     * @param DocumentItemInterface $item
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
