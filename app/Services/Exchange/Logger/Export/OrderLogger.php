<?php

namespace App\Services\Exchange\Logger\Export;

use App\Models\ExchangeLog;
use App\Services\Exchange\Logger\ExportLogger;

class OrderLogger extends ExportLogger
{
    public function addLog(string $message)
    {
        $data = [
            'type' => ExchangeLog::TYPE_ORDER,
            'message' => $message,
        ];
        $data = $this->prepareLogData($data);

        return $this->logRepository->create($data);
    }
}