<?php


namespace App\Erp\Contracts;


/**
 * 
 * Interface DocumentInterface
 * @package App\Erp\Contracts
 */
/**
 * Interface DocumentItemInterface
 * @package App\Erp\Contracts
 */
interface DocumentItemInterface
{


    /**
     * @return mixed
     */
    public function product();

    /**
     * Сток
     * @return mixed
     */
    public function stock();

    /**
     * Документ к которому относится данная строка
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document();

    /**
     * @param DocumentItemInterface $item
     * @return mixed
     */
    public function populateByDocumentItem(DocumentItemInterface $item);
    
    

}