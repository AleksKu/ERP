<?php

namespace App\Erp\Catalog;

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
 */
class ProductCategory extends Model
{


    protected $fillable = ['title', 'product_count'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

 

}
