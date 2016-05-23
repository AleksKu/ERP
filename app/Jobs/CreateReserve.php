<?php

namespace Torg\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Torg\Contracts\DocumentInterface;
use Torg\Repositories\StockReserveRepository;
use Torg\Stocks\Contracts\ShouldReserve;
use Torg\Stocks\Exceptions\StockException;

class CreateReserve extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var DocumentInterface
     */
    private $document;

    /**
     * Create a new job instance.
     *
     * @param ShouldReserve $document
     */
    public function __construct(ShouldReserve $document)
    {
        //
        $this->document = $document;
    }

    /**
     * Execute the job.
     *
     * @param StockReserveRepository $reserveRepository
     *
     * @throws StockException
     * @throws \Exception
     */
    public function handle(StockReserveRepository $reserveRepository)
    {

        $reserveRepository->createFromDocument($this->document);

    }
}
