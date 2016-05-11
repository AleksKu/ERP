<?php

namespace Torg\Base;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Store",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class Store extends Model
{
    use SoftDeletes;

    /**
     *
     */
    const DEFAULT_WAREHOUSE_TYPE = 1; //склад по умолчанию
    /**
     *
     */
    const RETURN_WAREHOUSE_TYPE = 2; //склад возврата
    /**
     *
     */
    const SALES_WAREHOUSE_TYPE = 3; //склад с которого ведутся отгрузки



    protected $with = ['defaultWarehouse'];
    /**
     * @var string
     */
    public $table = 'stores';


    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * @var array
     */
    public $fillable = [
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return BelongsToMany
     */
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class)->withPivot('type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function defaultWarehouse()
    {
        return $this->belongsToMany(Warehouse::class)
            ->wherePivot('type', static::DEFAULT_WAREHOUSE_TYPE);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function salesWarehouse()
    {
        return $this->belongsToMany(Warehouse::class)
            ->wherePivot('type', static::SALES_WAREHOUSE_TYPE);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function returnWarehouse()
    {
        return $this->belongsToMany(Warehouse::class)
            ->wherePivot('type', static::RETURN_WAREHOUSE_TYPE);
    }

    /**
     * @param Warehouse $warehouse
     */
    public function addDefaultWarehouse(Warehouse $warehouse)
    {
        $id = $warehouse->id;
        $this->warehouses()->attach([$id => ['type'=>static::DEFAULT_WAREHOUSE_TYPE]]);

        
    }
    
    public function account()
    {
        $this->belongsTo(Account::class);
    }
    
    public function company()
    {
        $this->belongsTo(Company::class);
    }
    
    
    
}
