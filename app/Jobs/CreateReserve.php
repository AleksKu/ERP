<?php

namespace App\Jobs;

use App\Erp\Stocks\Exceptions\StockException;
use App\Jobs\Job;
use App\Repositories\StockReserveRepository;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateReserve extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @var ShouldReserve
     */
    private $document;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ShouldReserve $document)
    {
        //
        $this->document = $document;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(StockReserveRepository $reserveRepository)
    {

        $reserveRepository->createFromDocument($this->document);


    }
}
