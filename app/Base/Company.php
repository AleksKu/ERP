<?php

namespace Torg\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Torg\Base\Company
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Warehouse[] $warehouses
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @mixin \Eloquent
 * @property-read \Torg\Base\Warehouse $defaultWarehouse
 * @property integer $default_warehouse_id
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereTitle($value)
 * @method static Builder|Company whereCode($value)
 * @method static Builder|Company whereDefaultWarehouseId($value)
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static Builder|Company whereDeletedAt($value)
 * @property integer $account_id
 * @method static Builder|Company whereAccountId($value)
 */
class Company extends Model
{

    /**
     * @var string
     */
    protected $table = 'companies';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

}
