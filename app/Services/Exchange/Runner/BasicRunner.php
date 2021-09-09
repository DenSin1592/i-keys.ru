<?php namespace App\Services\Exchange\Runner;

use App\Models\Product;
use App\Services\Exchange\Core\HandlerCollector;
use App\Services\Exchange\Locker\LockHandler;
use App\Services\Exchange\Logger\Logger;
use Illuminate\Support\LazyCollection;

abstract class BasicRunner
{
    private $handlerCollector;
    private $lockHandler;
    protected $logger;

    public function __construct(
        HandlerCollector $handlerCollector,
        LockHandler $lockHandler,
        Logger $logger
    ) {
        $this->handlerCollector = $handlerCollector;
        $this->lockHandler = $lockHandler;
        $this->logger = $logger;
    }

    public function run()
    {
        //to prevent memory leak
        \DB::disableQueryLog();

        if ($this->lockHandler->lock()) {
            $this->exchangeRunner();
            $this->lockHandler->unlock();
        }
    }

    protected function exchangeRunner(): void
    {
        $this->handlerCollector->handle();
    }
}
