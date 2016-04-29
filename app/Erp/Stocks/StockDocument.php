<?php

namespace App\Erp\Stocks;

use Illuminate\Database\Eloquent\Model;

use App\Erp\Catalog\Product;
use App\Erp\Organizations\Organization as Organization;
use App\Erp\Organizations\Warehouse;


abstract class StockDocument extends Model
{

    CONST STATUS_NEW = 'new';
    CONST STATUS_ACTIVATED = 'activated';
    CONST STATUS_COMPLETE = 'complete';
    CONST STATUS_CANCELED= 'canceled';


    protected static $statuses = [
        self::STATUS_NEW,
        self::STATUS_ACTIVATED,
        self::STATUS_COMPLETE,
        self::STATUS_CANCELED,
    ];


    protected $attributes = array(

        'weight' => 0,
        'volume' => 0,
        'total' => 0,
        'status' => self::STATUS_NEW

    );

    protected $with = ['items', 'warehouse', 'organization'];


    public function documentable()
    {
        return $this->morphTo();
    }


    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }


    /**
     * возвращает строки документв
     * @return mixed
     */
    public abstract function items();


    public function activate()
    {
        $items = $this->items;

        foreach ($items as $item) {
            $item->activate();
        }

        $this->status = self::STATUS_ACTIVATED;

        $this->save();

        return $this;
    }


    /**
     * Закрывает проведенный документ
     * @return $this
     */
    public function complete()
    {
        $items = $this->items;

        foreach ($items as $item) {
            $item->complete();
        }

        $this->status = self::STATUS_COMPLETE;

        $this->save();

        return $this;
    }

    public function cancel() {

    }



    public function duplicate(StockDocument $newDocument) {

    }

    public abstract function populateByDocument(StockDocument $document);


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