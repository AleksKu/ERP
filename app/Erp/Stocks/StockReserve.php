<?php

namespace App\Erp\Stocks;

use App\Erp\Catalog\Product;
use App\Erp\Organizations\Organization as Organization;
use App\Erp\Organizations\Warehouse;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * AQAL\Stocks\StockReserve
 *
 * @property-read \ $documentable
 * @property integer $id
 * @property string $code
 * @property integer $documentable_id
 * @property string $documentable_type
 * @property string $desc
 * @property integer $warehouse_id
 * @property integer $organization_id
 * @property float $weight
 * @property float $volume
 * @property float $total
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|StockReserveItem[] $items
 * @property-read Warehouse $warehouse
 * @property-read Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reasonable
 * @property-write mixed $status
 * @mixin \Eloquent
 */
class StockReserve extends  StockDocument
{

    


    protected $table = 'stock_reserves';

    public static $codePrefix = 'Резерв';

    public static $rules = [];
    
    protected $fillable = ['code', 'desc', 'status'];



  public static $itemInstance = StockReserveItem::class;






    public function codeForLinks($prefix)
    {
        // TODO: Implement codeForLinks() method.
    }




}
