<?php

namespace Torg\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Torg\Stocks\Stock;

/**
 * AQAL\Stocks\Warehouse
 *
 * @property-read Company $company
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property boolean $is_default_for_company
 * @property integer $company_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read Collection|Stock[] $stocks
 * @mixin \Eloquent
 * @method static Builder|Warehouse whereId($value)
 * @method static Builder|Warehouse whereTitle($value)
 * @method static Builder|Warehouse whereCode($value)
 * @method static Builder|Warehouse whereCompanyId($value)
 * @method static Builder|Warehouse whereCreatedAt($value)
 * @method static Builder|Warehouse whereUpdatedAt($value)
 * @method static Builder|Warehouse whereDeletedAt($value)
 * @property integer $account_id
 * @property-read \Torg\Base\Account $account
 * @method static Builder|Warehouse whereAccountId($value)
 */
class Warehouse extends Model
{

    /**
     * @var array
     */
    protected $with = [];

    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @var array
     */
    protected $casts = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }
}
