<?php

namespace App\Erp\Catalog;

use App\Erp\Contracts\OrderableInterface;
use Illuminate\Database\Eloquent\Model;

use App\Erp\Stocks\Stock;


/**
 * AQAL\Stocks\Product
 *
 * @property-read ProductCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|Stock[] $stocks
 * @mixin \Eloquent
 */
class Product extends Model implements OrderableInterface
{

    protected $attributes = [
        'weight'=>0,
        'volume'=>0,
        'price'=>0,
        'cost'=>0
    ];


    protected $fillable = ['title', 'sku','weight', 'volume','price','cost', 'category_id', 'description'];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function addToCategory(ProductCategory $category)
    {
        $this->category()->associate($category);

        $category->increment('product_count');
        $category->save();

    }

    public function removeFromCategory(ProductCategory $category)
    {
        $this->category()->dissociate($category);
        $category->decrement('product_count');
        $category->save();
    }
    
    public function moveToCategory(ProductCategory $category)
    {
        $oldCategory = $this->category();
        $oldCategory->decrement('product_count');
        $this->category()->associate($category);
        $category->increment('product_count');
        $category->save();
    }


    public function getPrice()
    {
       return $this->price;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getSku()
    {
        return $this->sku;
    }
}
