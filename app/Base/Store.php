<?php

namespace Torg\Base;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Torg\Base\Warehouse;

/**
 * Torg\Base\Store
 *
 * @SWG\Definition (
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
 * @property Company company
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property integer $account_id
 * @property integer $company_id
 * @property integer $default_warehouse_id
 * @property integer $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read Collection|Warehouse[] $warehouses
 * @property-read Collection|Warehouse[] $defaultWarehouse
 * @property-read Collection|Warehouse[] $salesWarehouse
 * @property-read Collection|Warehouse[] $returnWarehouse
 * @property-read \Torg\Base\Account $account
 * @method static Builder|Store whereId($value)
 * @method static Builder|Store whereCode($value)
 * @method static Builder|Store whereTitle($value)
 * @method static Builder|Store whereAccountId($value)
 * @method static Builder|Store whereCompanyId($value)
 * @method static Builder|Store whereDefaultWarehouseId($value)
 * @method static Builder|Store whereType($value)
 * @method static Builder|Store whereCreatedAt($value)
 * @method static Builder|Store whereUpdatedAt($value)
 * @method static Builder|Store whereDeletedAt($value)
 * @mixin \Eloquent
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

    /**
     * @var array
     */
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
        'title',
        'code',
        'account_id',
        'company_id',
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
            ->wherePivot('type', static::DEFAULT_WAREHOUSE_TYPE)
            ->withPivot('type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function salesWarehouse()
    {
        return $this->belongsToMany(Warehouse::class)
            ->wherePivot('type', static::SALES_WAREHOUSE_TYPE)
            ->withPivot('type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function returnWarehouse()
    {
        return $this->belongsToMany(Warehouse::class)
            ->wherePivot('type', static::RETURN_WAREHOUSE_TYPE)
            ->withPivot('type');
    }

    /**
     * @param Warehouse $warehouse
     *
     * @return $this
     */
    public function setSalesWarehouse(Warehouse $warehouse)
    {
        if ($this->getSalesWarehouse()) {
            $id = $this->getSalesWarehouse()->id;
            $this->warehouses()->detach([$id]);
        }
        $id = $warehouse->id;
        $this->warehouses()->attach([$id => ['type' => static::SALES_WAREHOUSE_TYPE]]);
        $this->_loadWarehousesRelations();

        return $this;

    }

    /**
     * @param Warehouse $warehouse
     *
     * @return $this
     */
    public function setDefaultWarehouse(Warehouse $warehouse)
    {
        if ($this->getDefaultWarehouse()) {
            $id = $this->getDefaultWarehouse()->id;
            $this->warehouses()->detach([$id]);
        }
        $id = $warehouse->id;
        $this->defaultWarehouse()->attach([$id => ['type' => static::DEFAULT_WAREHOUSE_TYPE]]);
        $this->_loadWarehousesRelations();

        return $this;
    }

    /**
     * @return Warehouse
     */
    public function getDefaultWarehouse()
    {
        return $this->defaultWarehouse->first();
    }

    /**
     * @return Warehouse
     */
    public function getSalesWarehouse()
    {
        return $this->salesWarehouse->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @param Company $company
     */
    public function setCompany(Company $company)
    {
        $this->company()->associate($company);
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     *
     */
    private function _loadWarehousesRelations()
    {
        $this->load(['warehouses', 'defaultWarehouse', 'salesWarehouse', 'returnWarehouse']);
    }

}
