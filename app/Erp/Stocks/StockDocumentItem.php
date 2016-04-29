<?php
/**
 * Created by PhpStorm.
 * User: newage
 * Date: 22.10.15
 * Time: 11:47
 */

namespace App\Erp\Stocks;

use Illuminate\Database\Eloquent\Model;

use App\Erp\Catalog\Product;


abstract class StockDocumentItem extends Model
{

    protected $with = ['product'];

    protected $touches = ['stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }


    /**
     * Возвращает документ к которуму относится данная строка документа
     * @return StockDocument
     */
    public abstract function document();

    /**
     * активация документа
     * @return StockDocumentItem
     */
    public abstract function activate();

    /**
     * деактивация документа
     * @return StockDocumentItem
     */
    public abstract function complete();


    /**
     * Заполняет поля на основание переданной строки документа
     * @param StockDocumentItem $item
     */

    public function populateByDocumentItem(StockDocumentItem $item)
    {
        $this->product()->associate($item->product);
        $this->document()->associate($item->document);
        $this->qty = $item->qty;
    }
}