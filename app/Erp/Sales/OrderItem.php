<?php

namespace App\Erp\Sales;

use App\Erp\Catalog\Product;
use App\Erp\Contracts\DocumentItemInterface;
use App\Erp\Stocks\Stock;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model implements DocumentItemInterface
{




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

        static::saving(function (OrderItem $orderItem) {
            $orderItem->checkStock();
            $orderItem->calculateTotals();
        });
    }


    public function checkStock()
    {
        if(!is_null($this->stock_id))
            return true;

        $warehouse = $this->order->warehouse;
        $product = $this->product;

        


    }
    
    public function calculateTotals()
    {
        
    }
    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }

    /**
     * Сток
     * @return mixed
     */
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    /**
     * Документ к которому относится данная строка
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document()
    {
        return $this->belongsTo(Order::class);
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
