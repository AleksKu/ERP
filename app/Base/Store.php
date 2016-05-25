<?php

namespace Torg\Base;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

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
 * @property integer $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read Collection|Warehouse[] $warehouses
 * @property-read Collection|Warehouse[] $defaultWarehouse
 * @property-read Collection|Warehouse[] $salesWarehouse
 * @property-read Collection|Warehouse[] $returnWarehouse
 * @property-read Account $account
 * @method static Builder|Store whereId($value)
 * @method static Builder|Store whereCode($value)
 * @method static Builder|Store whereTitle($value)
 * @method static Builder|Store whereAccountId($value)
 * @method static Builder|Store whereCompanyId($value)
 * @method static Builder|Store whereType($value)
 * @method static Builder|Store whereCreatedAt($value)
 * @method static Builder|Store whereUpdatedAt($value)
 * @method static Builder|Store whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Store extends Model
{
    use SoftDeletes;

    const RETAIL_TYPE = 1;

    const IM_TYPE = 2;

    const TYPES = [
        self::RETAIL_TYPE,
        self::IM_TYPE,
    ];

    /**
     * склад по умолчанию
     */
    const DEFAULT_WAREHOUSE_TYPE = 1;

    /**
     * склад возврата
     */
    const RETURN_WAREHOUSE_TYPE = 2;

    /**
     * склад с которого ведутся отгрузки
     */
    const SALES_WAREHOUSE_TYPE = 3;

    /**
     *
     */
    const WAREHOUSE_TYPES = [
        self::DEFAULT_WAREHOUSE_TYPE,
        self::SALES_WAREHOUSE_TYPE,
        self::RETURN_WAREHOUSE_TYPE,
    ];


    /**
     * @var array
     */
    protected $with = ['defaultWarehouse', 'salesWarehouse'];

    /**
     * @var string
     */
    public $table = 'stores';

    protected static $singleTableTypeField = 'type';

    protected static $singleTableSubclasses = [
        self::IM_TYPE => ImStore::class,
        self::RETAIL_TYPE => RetailStore::class
    ];

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
        'type',
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
        return $this->belongsToMany(Warehouse::class, 'store_warehouse', 'store_id')->withPivot('type');
    }

    /**
     * Create a new model instance that is existing.
     *
     * @param  array $attributes
     * @param  string|null $connection
     * @return static
     * @throws \LogicException
     */
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $type = $attributes->{self::$singleTableTypeField};
        if (!array_key_exists($type, self::$singleTableSubclasses)) {
            throw new \LogicException('invalid type given');
        }
        $class = self::$singleTableSubclasses[$type];
        /** @var Store $model */
        $model = (new $class)->newInstance([], true);
        $model->setRawAttributes((array) $attributes, true);
        $model->setConnection($connection ?: $this->connection);

        return $model;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function defaultWarehouse()
    {
        return $this->belongsToMany(Warehouse::class, 'store_warehouse', 'store_id')
            ->wherePivot('type', static::DEFAULT_WAREHOUSE_TYPE)
            ->withPivot('type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function salesWarehouse()
    {
        return $this->belongsToMany(Warehouse::class, 'store_warehouse', 'store_id')
            ->wherePivot('type', static::SALES_WAREHOUSE_TYPE)
            ->withPivot('type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function returnWarehouse()
    {
        return $this->belongsToMany(Warehouse::class, 'store_warehouse', 'store_id')
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
     * @return Collection|Warehouse[]
     */
    public function getWarehouses()
    {
        return $this->warehouses;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @param Account $account
     */
    public function setAccount(Account $account)
    {
        $this->account()->associate($account);
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     *
     */
    private function _loadWarehousesRelations()
    {
        $this->load(['warehouses', 'defaultWarehouse', 'salesWarehouse', 'returnWarehouse']);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
