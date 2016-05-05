<?php

namespace App\Erp\Organizations;

use Illuminate\Database\Eloquent\Model;

/**
 * AQAL\Organizations\Organization
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Warehouse[] $warehouses
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @mixin \Eloquent
 * @property-read \App\Erp\Organizations\Warehouse $defaultWarehouse
 * @property integer $default_warehouse_id
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Organizations\Organization whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Organizations\Organization whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Organizations\Organization whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Organizations\Organization whereDefaultWarehouseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Organizations\Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Organizations\Organization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Erp\Organizations\Organization whereDeletedAt($value)
 */
class Organization extends Model
{

    /**
     * обновляет поле update_at при обновлении указанных связей
     * @var array
     */
    protected $touches = ['warehouses'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }


    public function defaultWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'default_warehouse_id');
    }

    public function addDefaultWarehouse(Warehouse $warehouse)
    {
        $this->defaultWarehouse()->associate($warehouse);

    }
}
