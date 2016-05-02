<?php

namespace App\Erp\Sales;

use App\Erp\Contracts\DocumentInterface;
use app\Erp\Contracts\OrderableInterface;
use App\Erp\Organizations\Organization;
use App\Erp\Organizations\Warehouse;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Order",
 *      required={},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="code",
 *          description="code",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="organization_id",
 *          description="organization_id",
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
class Order extends Model implements DocumentInterface
{
    use SoftDeletes;

    public $table = 'orders';

    public $with = ['organization', 'warehouse'];


    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public static $itemInstance = OrderItem::class;


    protected $attributes = [
        'weight' => 0,
        'volume' => 0,
        'total_qty' => 0,
        'total' => 0,
    ];

    protected $fillable = [
        'code',
        'warehouse_id',
        'customer_id',
        'customer_name',
        'customer_email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


    public static function boot()
    {

        parent::boot();

        static::saving(function (Order $order) {
            $order->checkOrganization();
        });
    }


    /**
     *todo проверка на изменение органзиации
     */
    public function checkOrganization()
    {

        $org = $this->warehouse->organization;
        $this->organization()->associate($org);
    }


    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }


    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function items()
    {
        return $this->hasMany(static::$itemInstance);
    }


    /**
     * @param OrderableInterface $product
     * @param int $qty
     */
    public function addProduct(OrderableInterface $product, $qty = 1)
    {
        $item = new OrderItem();

       // $item->sku = $product->getSku();
        $item->price = $product->getPrice();
     //   $item->cost = $product->getCost();
        $item->qty = $qty;
        $item->weight = $product->weight;

        $item->product_id = $product->id;

        
        $stock = $stockRepo->findOrCreate($product, $this->warehouse);

        $item->stock_id = $stock->id;

        $this->items()->save($item);
    }


}
