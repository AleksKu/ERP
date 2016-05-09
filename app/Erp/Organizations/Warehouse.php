<?php

namespace Torg\Erp\Organizations;

use Illuminate\Database\Eloquent\Model;

use Torg\Erp\Stocks\Stock;



/**
 * AQAL\Stocks\Warehouse
 *
 * @property-read Organization $organization
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property boolean $is_default_for_organization
 * @property integer $organization_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Torg\Erp\Stocks\Stock[] $stocks
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Organizations\Warehouse whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Organizations\Warehouse whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Organizations\Warehouse whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Organizations\Warehouse whereOrganizationId($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Organizations\Warehouse whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Organizations\Warehouse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Torg\Erp\Organizations\Warehouse whereDeletedAt($value)
 */
class Warehouse extends Model
{

    protected $with = ['organization'];

    protected $attributes = array(

    );

    protected $casts = [
     
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function getOrganization()
    {
        return $this->organization;
    }
}
