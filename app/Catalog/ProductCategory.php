<?php

namespace Torg\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * AQAL\Stocks\ProductCategory
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @mixin \Eloquent
 * @property integer $product_count
 * @method static Builder|ProductCategory whereId($value)
 * @method static Builder|ProductCategory whereTitle($value)
 * @method static Builder|ProductCategory whereProductCount($value)
 * @method static Builder|ProductCategory whereCreatedAt($value)
 * @method static Builder|ProductCategory whereUpdatedAt($value)
 * @method static Builder|ProductCategory whereDeletedAt($value)
 */
class ProductCategory extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['title', 'product_count'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
