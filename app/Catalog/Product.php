<?php

namespace Torg\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Torg\Contracts\OrderableInterface;
use Torg\Stocks\Stock;

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
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereType($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereTitle($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereUnitId($value)
 * @method static Builder|Product whereBarcodes($value)
 * @method static Builder|Product whereAttributes($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereCost($value)
 * @method static Builder|Product whereWeight($value)
 * @method static Builder|Product whereVolume($value)
 * @method static Builder|Product whereImage($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereDeletedAt($value)
 */
class Product extends Model implements OrderableInterface
{

    /**
     * @var array
     */
    protected $attributes = [
        'weight' => 0,
        'volume' => 0,
        'price' => 0,
        'cost' => 0,
    ];

    /**
     * @var array
     */
    protected $fillable = ['title', 'sku', 'weight', 'volume', 'price', 'cost', 'category_id', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * @param ProductCategory $category
     */
    public function addToCategory(ProductCategory $category)
    {
        $this->category()->associate($category);

        $category->increment('product_count');
        $category->save();

    }

    /**
     * @param ProductCategory $category
     */
    public function removeFromCategory(ProductCategory $category)
    {
        $this->category()->dissociate($category);
        $category->decrement('product_count');
        $category->save();
    }

    /**
     * @param ProductCategory $category
     */
    public function moveToCategory(ProductCategory $category)
    {
        $oldCategory = $this->category();
        $oldCategory->decrement('product_count');
        $this->category()->associate($category);
        $category->increment('product_count');
        $category->save();
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }
}
