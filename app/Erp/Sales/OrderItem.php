<?php

namespace App\Erp\Sales;

use App\Erp\Catalog\Product;
use App\Erp\Contracts\DocumentItemInterface;
use App\Erp\Stocks\Contracts\ReservebleItem;
use App\Erp\Stocks\Contracts\ShouldReserve;
use App\Erp\Stocks\Stock;
use App\Events\ReservebleItemCreating;
use App\Events\ReservebleItemSaving;
use Illuminate\Database\Eloquent\Model;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Сток
     * @return mixed
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
}
