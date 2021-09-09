<?php

namespace App\Services\DataProviders\ExchangeView;

use App\Services\Repositories\ExchangeLog\ExchangeLogRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ExchangeViewProvider
{
    private const IMPORT_LOGS_LIMIT = 50;
    private const EXPORT_LOGS_LIMIT = 50;
    /**
     * Logs for last 7 days
     */
    private const IMPORT_LOGS_DAYS_LIMIT = 7;
    private const EXPORT_LOGS_DAYS_LIMIT = 7;

    private $logRepository;

    /**
     * ExchangeViewProvider constructor.
     * @param ExchangeLogRepository $logRepository
     */
    public function __construct(ExchangeLogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    public function provideDataForView(): array
    {
        $data = [];
        $data = array_merge(
            $data,
            $this->getImportLogs(),
            $this->getExportLogs()
        );

        return $data;
    }

    public function getImportLogs(int $page = 1): array
    {
        $importLogs = $this->getPaginatorByCallback(
            function ($page, $limit) {
                return $this->logRepository->getImportUnsolvedLogsByPage($page, $limit, self::IMPORT_LOGS_DAYS_LIMIT);
            },
            route('cc.exchange.import.logs'),
            $page,
            self::IMPORT_LOGS_LIMIT
        );

        return ['importLogs' => $importLogs, 'importLogsDaysLimit' => self::IMPORT_LOGS_DAYS_LIMIT];
    }

    public function getExportLogs(int $page = 1): array
    {
        $exportLogs = $this->getPaginatorByCallback(
            function ($page, $limit) {
                return $this->logRepository->getExportUnsolvedLogsByPage($page, $limit, self::EXPORT_LOGS_DAYS_LIMIT);
            },
            route('cc.exchange.export.logs'),
            $page,
            self::EXPORT_LOGS_LIMIT
        );

        return ['exportLogs' => $exportLogs, 'exportLogsDaysLimit' => self::EXPORT_LOGS_DAYS_LIMIT];
    }

    private function getPaginatorByCallback(
        callable $paginatorCallback,
        string $baseUrl,
        int $page,
        int $limit
    ): LengthAwarePaginator {
        if ($page < 1) {
            $page = 1;
        }
        $paginatorStructure = $paginatorCallback($page, $limit);
        if ($page > 1 && $paginatorStructure['items']->count() === 0 && $paginatorStructure['total'] > 0) {
            $page = 1;
            $paginatorStructure = $paginatorCallback($page, $limit);
        }

        $paginator = new LengthAwarePaginator(
            $paginatorStructure['items']->all(),
            $paginatorStructure['total'],
            $paginatorStructure['limit'],
            $paginatorStructure['page']
        );
        $paginator->setPath($baseUrl);

        return $paginator;
    }
}