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
