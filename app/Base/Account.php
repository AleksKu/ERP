<?php

namespace Torg\Base;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * Torg\Base\Account
 *
 * @SWG\Definition (
 *      definition="Account",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="title",
 *          description="title",
 *          type="string"
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
 * @property integer $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read Collection|\Torg\Base\User[] $users
 * @property-read Collection|\Torg\Base\Store[] $stores
 * @property-read Collection|\Torg\Base\Warehouse[] $warehouses
 * @method static Builder|Account whereId($value)
 * @method static Builder|Account whereTitle($value)
 * @method static Builder|Account whereCreatedAt($value)
 * @method static Builder|Account whereUpdatedAt($value)
 * @method static Builder|Account whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Account extends Model
{
    use SoftDeletes;

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @var string
     */
    public $table = 'accounts';

    /**
     * @var array
     */
    public $fillable = [
        'title',
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
    ];

    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);

    }

    /**
     * @return HasMany
     */
    public function stores()
    {
        return $this->hasMany(Store::class);

    }

    /**
     * @return HasMany
     */
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);

    }
    

}
