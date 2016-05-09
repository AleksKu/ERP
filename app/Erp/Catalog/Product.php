<?php

namespace Torg\Erp\Catalog;

use Torg\Erp\Contracts\OrderableInterface;
use Illuminate\Database\Eloquent\Model;

use Torg\Erp\Stocks\Stock;


/**
 * AQAL\Stocks\Product
 *
 * @property-read ProductCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|Stock[] $stocks
 * @mixin \Eloquent
 * @property integer $id
 * @property string $type
 * @property string $sku
 * @property integer $category_id
 * @property string $title
 * @property string $description
 * @property integer $unit_id
 * @property string $barcodes
 * @property string $attributes
 * @property float $price
 * @property float $cost
 * @property float $weight
 * @property float $volume
 * @property string $image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereSku($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereUnitId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereBarcodes($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereAttributes($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereCost($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereVolume($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Catalog\Product whereDeletedAt($value)
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
