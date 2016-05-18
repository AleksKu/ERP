<?php

namespace Torg\Base;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Torg\Base\User;

/**
 * @SWG\Definition(
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
 */
class Account extends Model
{
    use SoftDeletes;

    public $table = 'accounts';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function users()
    {
        return $this->hasMany(User::class);

    }

    public function stores()
    {
        return $this->hasMany(Store::class);

    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);

    }
    
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    
    

}
