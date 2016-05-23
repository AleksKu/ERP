<?php

namespace Torg\Stocks;

use Illuminate\Database\Query\Builder;
use Torg\Base\Company;
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
 * @method static Builder|StockReserve whereId($value)
 * @method static Builder|StockReserve whereCode($value)
 * @method static Builder|StockReserve whereStatus($value)
 * @method static Builder|StockReserve whereReasonableId($value)
 * @method static Builder|StockReserve whereReasonableType($value)
 * @method static Builder|StockReserve whereDesc($value)
 * @method static Builder|StockReserve whereWarehouseId($value)
 * @method static Builder|StockReserve whereWeight($value)
 * @method static Builder|StockReserve whereVolume($value)
 * @method static Builder|StockReserve whereTotal($value)
 * @method static Builder|StockReserve whereCreatedAt($value)
 * @method static Builder|StockReserve whereUpdatedAt($value)
 * @method static Builder|StockReserve whereDeletedAt($value)
 */
class StockReserve extends StockDocument
{

    /**
     * @var string
     */
    public static $codePrefix = 'Резерв';

    /**
     * @var array
     */
    public static $rules = [];

    /**
     * @var
     */
    public static $itemInstance = StockReserveItem::class;

    /**
     * @var string
     */
    protected $table = 'stock_reserves';

    /**
     * @var array
     */
    protected $fillable = ['code', 'desc', 'status'];

    /**
     * @param $prefix
     */
    public function codeForLinks($prefix)
    {
        // TODO: Implement codeForLinks() method.
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     */
    public function store()
    {
        // TODO: Implement store() method.
    }

    /**
     *
     */
    public function getStore()
    {
        // TODO: Implement getStore() method.
    }
}
