<?php

namespace App\Erp\Catalog;

use Illuminate\Database\Eloquent\Model;


/**
 * AQAL\Stocks\Product
 *
 * @property-read ProductCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|Stock[] $stocks
 */
class Product extends Model
{



    protected $fillable = ['title', 'sku', 'category_id', 'description'];

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


}
