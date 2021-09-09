<?php namespace App\Services\Exchange\Logger;

use App\Models\ExchangeLog;
use App\Services\Repositories\ExchangeLog\ExchangeLogRepository;

/**
 * Class ImportLogger
 * @package App\Services\Exchange\Logger
 */
class ImportLogger extends Logger
{
    public function __construct(ExchangeLogRepository $logRepository)
    {
        parent::__construct($logRepository, ExchangeLog::EXCHANGE_TYPE_IMPORT);
    }
}
