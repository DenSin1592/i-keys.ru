<?php

namespace App\Services\Exchange\Logger\Import;

use App\Models\ExchangeLog;
use App\Services\Exchange\Logger\ImportLogger;
use App\Services\Repositories\ExchangeLog\ExchangeLogRepository;

class AttributeLogger extends ImportLogger
{
    private static $attributeCodes1c;

    /**
     * AttributeLogger constructor.
     * @param ExchangeLogRepository $logRepository
     */
    public function __construct(ExchangeLogRepository $logRepository)
    {
        parent::__construct($logRepository);
        $this->setAttributeCodes1c();
    }

    public function addLog(string $fileName, $lineNumber, string $message, string $attributeCode1c = null)
    {
        $data = [
            'type' => ExchangeLog::TYPE_ATTRIBUTE,
            'attribute_code_1c' => $attributeCode1c,
            'message' => $message,
            'file_name' => $fileName,
            'line_number' => $lineNumber,
        ];
        $data = $this->prepareLogData($data);
        $this->addToAttributeCodes1c($attributeCode1c);

        return $this->logRepository->create($data);
    }

    public function solveLogs(string $attributeCode1c): void
    {
        if (in_array($attributeCode1c, self::$attributeCodes1c)) {
            $this->logRepository->solveImportAttributeLogs($attributeCode1c);
            $this->removeFromAttributeCodes1c($attributeCode1c);
        }
    }

    private function setAttributeCodes1c(): void
    {
        if (!isset(self::$attributeCodes1c)) {
            self::$attributeCodes1c = $this->logRepository
                ->getUnsolvedImportLogsByType(ExchangeLog::TYPE_ATTRIBUTE, true)
                ->pluck('attribute_code_1c')
                ->all();
        }
    }

    private function addToAttributeCodes1c($attributeCode1c): void
    {
        if (!empty($attributeCode1c)) {
            if (!in_array($attributeCode1c, self::$attributeCodes1c)) {
                self::$attributeCodes1c[] = $attributeCode1c;
            }
        }
    }

    private function removeFromAttributeCodes1c($attributeCode1c): void
    {
        self::$attributeCodes1c = array_filter(
            self::$attributeCodes1c,
            function ($value) use ($attributeCode1c) {
                return $value != $attributeCode1c;
            }
        );
    }
}