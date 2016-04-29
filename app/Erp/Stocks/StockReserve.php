<?php

namespace App\Erp\Stocks;

use App\Erp\Catalog\Product;
use App\Erp\Organizations\Organization as Organization;
use App\Erp\Organizations\Warehouse;



/**
 * AQAL\Stocks\StockReserve
 *
 * @property-read \ $documentable
 * @property integer $id
 * @property string $code
 * @property integer $documentable_id
 * @property string $documentable_type
 * @property string $desc
 * @property integer $warehouse_id
 * @property integer $organization_id
 * @property float $weight
 * @property float $volume
 * @property float $total
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at

 * @property-read \Illuminate\Database\Eloquent\Collection|StockReserveItem[] $items
 * @property-read Warehouse $warehouse
 * @property-read Organization $organization
 */
class StockReserve extends  StockDocument
{


    protected $table = 'stock_reserves';

    public static $codePrefix = 'Резерв';



    public function items()
    {
        return $this->hasMany(StockReserveItem::class);
    }




    /**
     * Заполняет поля на основании документа
     * @param StockDocument $document
     */
    public function populateByDocument(StockDocument $document)
    {
        $this->warehouse()->associate($document->warehouse);
        $this->organization()->associate($document->organization);
        $this->documentable()->associate($document);

        $this->code = $document->codeForLinks(StockReserve::$codePrefix);

    }


    public function codeForLinks($prefix)
    {
        // TODO: Implement codeForLinks() method.
    }




}
