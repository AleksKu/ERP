<?php

namespace Torg\Catalog;

use Illuminate\Database\Eloquent\Model;


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
 * @method static \Illuminate\Database\Query\Builder|\Torg\Catalog\ProductCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Catalog\ProductCategory whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Catalog\ProductCategory whereProductCount($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Catalog\ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Catalog\ProductCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Catalog\ProductCategory whereDeletedAt($value)
 */
class ProductCategory extends Model
{


    protected $fillable = ['title', 'product_count'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

 

}
