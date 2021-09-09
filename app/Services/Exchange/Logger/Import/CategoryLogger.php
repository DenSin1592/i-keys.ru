<?php

namespace App\Services\Exchange\Logger\Import;

use App\Models\ExchangeLog;
use App\Services\Exchange\Logger\ImportLogger;
use App\Services\Repositories\ExchangeLog\ExchangeLogRepository;

class CategoryLogger extends ImportLogger
{
    private static $categoryCodes1c;

    /**
     * CategoryLogger constructor.
     * @param ExchangeLogRepository $logRepository
     */
    public function __construct(ExchangeLogRepository $logRepository)
    {
        parent::__construct($logRepository);
        $this->setCategoryCodes1c();
    }

    public function addLog(string $fileName, $lineNumber, string $message, string $categoryCode1c = null)
    {
        $data = [
            'type' => ExchangeLog::TYPE_CATEGORY,
            'category_code_1c' => $categoryCode1c,
            'message' => $message,
            'file_name' => $fileName,
            'line_number' => $lineNumber,
        ];
        $data = $this->prepareLogData($data);
        $this->addToCategoryCodes1c($categoryCode1c);

        return $this->logRepository->create($data);
    }

    public function solveLogs(string $categoryCode1c): void
    {
        if (in_array($categoryCode1c, self::$categoryCodes1c)) {
            $this->logRepository->solveImportCategoryLogs($categoryCode1c);
            $this->removeFromCategoryCodes1c($categoryCode1c);
        }
    }

    private function setCategoryCodes1c(): void
    {
        if (!isset(self::$categoryCodes1c)) {
            self::$categoryCodes1c = $this->logRepository
                ->getUnsolvedImportLogsByType(ExchangeLog::TYPE_CATEGORY, true)
                ->pluck('category_code_1c')
                ->all();
        }
    }

    private function addToCategoryCodes1c($categoryCode1c): void
    {
        if (!empty($categoryCode1c)) {
            if (!in_array($categoryCode1c, self::$categoryCodes1c)) {
                self::$categoryCodes1c[] = $categoryCode1c;
            }
        }
    }

    private function removeFromCategoryCodes1c($categoryCode1c): void
    {
        self::$categoryCodes1c = array_filter(
            self::$categoryCodes1c,
            function ($value) use ($categoryCode1c) {
                return $value != $categoryCode1c;
            }
        );
    }
}