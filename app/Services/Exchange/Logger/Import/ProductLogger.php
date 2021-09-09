<?php

namespace App\Services\Exchange\Logger\Import;

use App\Models\ExchangeLog;
use App\Services\Exchange\Logger\ImportLogger;
use App\Services\Repositories\ExchangeLog\ExchangeLogRepository;

class ProductLogger extends ImportLogger
{
    private static $productCodes1c;

    /**
     * ProductLogger constructor.
     * @param ExchangeLogRepository $logRepository
     */
    public function __construct(ExchangeLogRepository $logRepository)
    {
        parent::__construct($logRepository);
        $this->setProductCodes1c();
    }

    public function addLog(string $fileName, $lineNumber, string $message, string $productCode1c = null)
    {
        $data = [
            'type' => ExchangeLog::TYPE_PRODUCT,
            'product_code_1c' => $productCode1c,
            'message' => $message,
            'file_name' => $fileName,
            'line_number' => $lineNumber,
        ];
        $data = $this->prepareLogData($data);
        $this->addToProductCodes1c($productCode1c);

        return $this->logRepository->create($data);
    }

    public function solveLogs(string $productCode1c): void
    {
        if (in_array($productCode1c, self::$productCodes1c)) {
            $this->logRepository->solveImportProductLogs($productCode1c);
            $this->removeFromProductCodes1c($productCode1c);
        }
    }

    private function setProductCodes1c(): void
    {
        if (!isset(self::$productCodes1c)) {
            self::$productCodes1c = $this->logRepository
                ->getUnsolvedImportLogsByType(ExchangeLog::TYPE_PRODUCT, true)
                ->pluck('product_code_1c')
                ->all();
        }
    }

    private function addToProductCodes1c($productCode1c): void
    {
        if (!empty($productCode1c)) {
            if (!in_array($productCode1c, self::$productCodes1c)) {
                self::$productCodes1c[] = $productCode1c;
            }
        }
    }

    private function removeFromProductCodes1c($productCode1c): void
    {
        self::$productCodes1c = array_filter(
            self::$productCodes1c,
            function ($value) use ($productCode1c) {
                return $value != $productCode1c;
            }
        );
    }
}