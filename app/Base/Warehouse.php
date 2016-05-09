<?php

namespace Torg\Base;

use Illuminate\Database\Eloquent\Model;

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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Torg\Stocks\Stock[] $stocks
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Warehouse whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Warehouse whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Warehouse whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Warehouse whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Warehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Warehouse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Base\Warehouse whereDeletedAt($value)
 */
class Warehouse extends Model
{

    protected $with = ['company'];

    protected $attributes = array(

    );

    protected $casts = [
     
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function getCompany()
    {
        return $this->company;
    }
}
