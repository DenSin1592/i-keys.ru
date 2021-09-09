<?php namespace App\Services\Exchange\Runner;

use App\Services\Exchange\Core\HandlerCollector;
use App\Services\Exchange\Logger\ExportLogger;
use App\Services\Exchange\Locker\LockHandler;

/**
 * Class ExportRunner
 * @package App\Services\Exchange\Runner
 */
class ExportRunner extends BasicRunner
{
    /**
     * ExportRunner constructor.
     * @param HandlerCollector $handlerCollector
     * @param LockHandler $lockStatusHandler
     * @param ExportLogger $logger
     */
    public function __construct(
        HandlerCollector $handlerCollector,
        LockHandler $lockStatusHandler,
        ExportLogger $logger
    ) {
        parent::__construct($handlerCollector, $lockStatusHandler, $logger);
    }
}
