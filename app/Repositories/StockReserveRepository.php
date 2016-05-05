<?php

namespace App\Repositories;

use App\Erp\Contracts\DocumentInterface;
use App\Erp\Stocks\Exceptions\StockException;
use App\Erp\Stocks\StockDocument;
use App\Erp\Stocks\StockReserve;
use InfyOm\Generator\Common\BaseRepository;

class StockReserveRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return StockReserve::class;
    }

    /**
     * @param DocumentInterface $document
     *
     * @return StockReserve
     */

    public function findByDocument(DocumentInterface $document)
    {
        $warehouseId = $document->warehouse->id;
        $documentId = $document->id;
        
        $reserve = StockReserve::where('warehouse_id', $warehouseId)
            
            ->first();




    }

    /**
     * Создает резерв на основании документа
     * @param DocumentInterface $document
     * @param bool $force форсировать создание. В таком случае, если резерв уже был создан, он будет снят и создан новый резерв
     * Если форсировать не надо, а резерв уже сущесвует для документа, то выбросит исключение
     * @return StockReserve
     * @throws StockException
     * @oaram bool $activate - если true резерв создается и активируется, т.е. происходит реальный резерв. Если false -
     * документ резерва создается но резерв не устанавилвается
     */
    public function createFromDocument(DocumentInterface $document, $activate = true, $force = false)
    {
        $existingReserve = $this->findByDocument($document);
        if($existingReserve && $force === false)
            throw new StockException('резерв уже создан для этого документа');

        if($existingReserve && $force === true)
           return $this->updateFromDocument($document);


        $reserve = new StockReserve();
        $reserve->populateByDocument($document);


        if($activate === true)
            $reserve->activate();

        $reserve->save();


        return $this->parserResult($reserve);

    }

    /**
     * @param DocumentInterface $document
     * @return StockReserve
     * @throws StockException
     * @throws \Exception
     */
    public function updateFromDocument(DocumentInterface $document)
    {
        $existingReserve = $this->findByDocument($document);

        //удаляем существующий резерв
        $existingReserve->delete();

        return $this->createFromDocument($document);
    }
}
