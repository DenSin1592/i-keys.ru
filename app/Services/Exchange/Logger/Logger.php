<?php namespace App\Services\Exchange\Logger;

use App\Models\ExchangeLog;
use App\Services\Repositories\ExchangeLog\ExchangeLogRepository;

abstract class Logger
{
    protected $logRepository;
    protected $exchangeType;

    /**
     * Logger constructor.
     * @param ExchangeLogRepository $logRepository
     * @param string $exchangeType
     */
    public function __construct(ExchangeLogRepository $logRepository, string $exchangeType)
    {
        $this->logRepository = $logRepository;
        $this->exchangeType = $exchangeType;
    }

    public function addErrorLog(string $message)
    {
        $data = [
            'type' => ExchangeLog::TYPE_ERROR,
            'message' => $message,
        ];
        $data = $this->prepareLogData($data);

        return $this->logRepository->create($data);
    }

    protected function prepareLogData(array $data): array
    {
        $data = array_filter(
            $data,
            function ($value) {
                return !isset($value) || trim($value) !== '';
            }
        );
        $data['exchange_type'] = $this->exchangeType;

        return $data;
    }
}