<?php

namespace Torg\Erp\Stocks;


use Torg\Base\Company as Company;
use Torg\Base\Warehouse;



/**
 * AQAL\Stocks\StockReserve
 *
 * @property integer $id
 * @property string $code
 * @property string $desc
 * @property integer $warehouse_id
 * @property integer $company_id
 * @property float $weight
 * @property float $volume
 * @property float $total
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|StockReserveItem[] $items
 * @property-read Warehouse $warehouse
 * @property-read Company $company
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reasonable
 * @property-write mixed $status
 * @mixin \Eloquent
 * @property integer $reasonable_id
 * @property string $reasonable_type
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereReasonableId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereReasonableType($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereVolume($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Stocks\StockReserve whereDeletedAt($value)
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

    public function getId()
    {
        return $this->id;
    }




}
