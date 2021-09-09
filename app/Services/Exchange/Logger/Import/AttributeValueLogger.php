<?php

namespace App\Services\Exchange\Logger\Import;

use App\Models\ExchangeLog;
use App\Services\Exchange\Logger\ImportLogger;
use App\Services\Repositories\ExchangeLog\ExchangeLogRepository;

class AttributeValueLogger extends ImportLogger
{
    private static $attributeProductCodes1cMatches;

    /**
     * CategoryLogger constructor.
     * @param ExchangeLogRepository $logRepository
     */
    public function __construct(ExchangeLogRepository $logRepository)
    {
        parent::__construct($logRepository);
        $this->setAttributeProductCodes1cMatches();
    }

    public function addLog(
        string $fileName,
        $lineNumber,
        string $message,
        string $attributeCode1c = null,
        string $productCode1c = null
    ) {
        $data = [
            'type' => ExchangeLog::TYPE_ATTRIBUTE_VALUE,
            'attribute_code_1c' => $attributeCode1c,
            'product_code_1c' => $productCode1c,
            'message' => $message,
            'file_name' => $fileName,
            'line_number' => $lineNumber,
        ];
        $data = $this->prepareLogData($data);
        $this->addToAttributeProductCodes1cMatches($attributeCode1c, $productCode1c);

        return $this->logRepository->create($data);
    }

    public function solveLogs(string $attributeCode1c, string $productCode1c): void
    {
        if (in_array(
            $this->getAttributeProductCodes1cMatch($attributeCode1c, $productCode1c),
            self::$attributeProductCodes1cMatches
        )) {
            $this->logRepository->solveImportAttributeValueLogs($attributeCode1c, $productCode1c);
            $this->removeFromAttributeProductCodes1cMatches($attributeCode1c, $productCode1c);
        }
    }

    private function getAttributeProductCodes1cMatch(string $attributeCode1c, string $productCode1c): string
    {
        return $attributeCode1c . '_' . $productCode1c;
    }

    private function setAttributeProductCodes1cMatches(): void
    {
        if (!isset(self::$attributeProductCodes1cMatches)) {
            $logs = $this->logRepository
                ->getUnsolvedImportLogsByType(ExchangeLog::TYPE_ATTRIBUTE_VALUE, true);

            self::$attributeProductCodes1cMatches = [];
            foreach ($logs as $log) {
                self::$attributeProductCodes1cMatches[] =
                    $this->getAttributeProductCodes1cMatch($log->attribute_code_1c, $log->product_code_1c);
            }
        }
    }

    private function addToAttributeProductCodes1cMatches($attributeCode1c, $productCode1c): void
    {
        if (!empty($attributeCode1c) && !empty($productCode1c)) {
            $attributeProductCodes1cMatch = $this->getAttributeProductCodes1cMatch($attributeCode1c, $productCode1c);
            if (!in_array($attributeProductCodes1cMatch, self::$attributeProductCodes1cMatches)) {
                self::$attributeProductCodes1cMatches[] = $attributeProductCodes1cMatch;
            }
        }
    }

    private function removeFromAttributeProductCodes1cMatches($attributeCode1c, $productCode1c): void
    {
        $attributeProductCodes1cMatch = $this->getAttributeProductCodes1cMatch($attributeCode1c, $productCode1c);

        self::$attributeProductCodes1cMatches = array_filter(
            self::$attributeProductCodes1cMatches,
            function ($value) use ($attributeProductCodes1cMatch) {
                return $value != $attributeProductCodes1cMatch;
            }
        );
    }
}