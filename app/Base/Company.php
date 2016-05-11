<?php

namespace Torg\Base;

use Illuminate\Database\Eloquent\Model;

/**
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
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Company whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Company whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Company whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Company whereDefaultWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Company whereDeletedAt($value)
 */
class Company extends Model
{

    protected $table = 'companies';


    public function account()
    {
        $this->belongsTo(Account::class);
    }

}
