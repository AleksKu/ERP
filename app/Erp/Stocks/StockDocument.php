<?php

namespace App\Erp\Stocks;

use App\Erp\Stocks\Exceptions\StockException;
use Illuminate\Database\Eloquent\Model;

use App\Erp\Organizations\Warehouse;


abstract class StockDocument extends Model
{

    CONST STATUS_NEW = 'new';
    CONST STATUS_ACTIVATED = 'activated';
    CONST STATUS_COMPLETE = 'complete';
    CONST STATUS_CANCELED = 'canceled';


    protected static $statuses = [
        self::STATUS_NEW,
        self::STATUS_ACTIVATED,
        self::STATUS_COMPLETE,
        self::STATUS_CANCELED,
    ];

    public static $codePrefix;

    public static $itemInstance;



    protected $attributes = array(

        'weight' => 0,
        'volume' => 0,
        'total' => 0,
        'status' => self::STATUS_NEW

    );

    protected $with = ['items', 'warehouse'];


    /**
     * Boot the model.
     */
    public static function boot()
    {
        parent::boot();
        static::updating(function($document) {
            $document->warehouseValidate();
        });
    }


    protected function warehouseValidate()
    {

    }


    public function documentable()
    {
        return $this->morphTo();
    }




    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }





    public function items()
    {
        return $this->hasMany(static::$itemInstance);
    }



    public function activate()
    {
        $items = $this->items;

        array_walk($items, function($item) {
            $item->activate();

        });

        $this->status = self::STATUS_ACTIVATED;


        return $this;
    }


    /**
     * Закрывает проведенный документ
     * @return $this
     */
    public function complete()
    {
        $items = $this->items;


        array_walk($items, function($item) {
            $item->complete();

        });

        $this->status = self::STATUS_COMPLETE;


        return $this;
    }

    public function cancel()
    {

    }


    public function duplicate(StockDocument $newDocument)
    {

    }

    /**
     * Заполняет поля на основании документа
     * @param StockDocument $document
     */
    public function populateByDocument(StockDocument $document)
    {
        $this->warehouse()->associate($document->warehouse);

        $this->documentable()->associate($document);

        $this->code = $document->codeForLinks(static::$codePrefix);

    }


    public function setStatusAttribute($status)
    {
        if (!in_array($status, $this->getAllStatuses()))
            throw new \InvalidArgumentException('неизвестный статус документа');


        $this->attributes['status'] = $status;

        return $this;
    }


    public function getAllStatuses()
    {
        return static::$statuses;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_NEW;
    }


}