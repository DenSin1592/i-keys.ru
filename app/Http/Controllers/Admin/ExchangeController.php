<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DataProviders\ExchangeView\ExchangeViewProvider;
use App\Services\Exchange\Locker\LockerException;
use App\Services\Exchange\Locker\LockHandler;
use App\Services\Exchange\StatusHandler\ExportStatusHandler;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    const EXCHANGE_STATUS_IN_PROGRESS = 'in_progress';
    const EXCHANGE_STATUS_WAITING = 'waiting';

    private $importLocker;
    private $exportLocker;
    private $importStatusHandler;
    private $exportStatusHandler;
    private $exchangeViewProvider;

    public function __construct(
        LockHandler $importLocker,
        LockHandler $exportLocker,
        ImportStatusHandler $importStatusHandler,
        ExportStatusHandler $exportStatusHandler,
        ExchangeViewProvider $exchangeViewProvider
    ) {
        $this->importLocker = $importLocker;
        $this->exportLocker = $exportLocker;
        $this->importStatusHandler = $importStatusHandler;
        $this->exportStatusHandler = $exportStatusHandler;
        $this->exchangeViewProvider = $exchangeViewProvider;
    }

    public function show()
    {
        $viewData = array_merge(
            $this->getImportData(),
            $this->getExportData(),
            $this->exchangeViewProvider->provideDataForView()
        );

        return \View::make('admin.exchange.show', $viewData);
    }

    public function importStatus(Request $request)
    {
        if (!$request->ajax()) {
            \App::abort(404, 'Page is not found');
        }

        $importData = $this->getImportData();
        $importStatusBlock = \View::make('admin.exchange._import._status')
            ->with($importData)
            ->render();

        return \Response::json(
            [
                'import_status_block' => $importStatusBlock,
                'current_import_status' => $importData['currentImportStatus'],
            ]
        );
    }

    public function exportStatus(Request $request)
    {
        if (!$request->ajax()) {
            \App::abort(404, 'Page is not found');
        }
        $exportData = $this->getExportData();

        $exportStatusBlock = \View::make('admin.exchange._export._status')
            ->with($exportData)
            ->render();

        return \Response::json(
            [
                'export_status_block' => $exportStatusBlock,
                'current_export_status' => $exportData['currentExportStatus'],
            ]
        );
    }

    public function importLogs(Request $request)
    {
        if (!$request->ajax()) {
            \App::abort(404, 'Page is not found');
        }
        $page = (int)$request->get('page');

        return \View::make('admin.exchange._import._logs')
            ->with($this->exchangeViewProvider->getImportLogs($page))
            ->render();
    }

    public function exportLogs(Request $request)
    {
        if (!$request->ajax()) {
            \App::abort(404, 'Page is not found');
        }
        $page = (int)$request->get('page');

        return \View::make('admin.exchange._export._logs')
            ->with($this->exchangeViewProvider->getExportLogs($page))
            ->render();
    }

    private function getImportData()
    {
        try {
            if ($this->importLocker->lock()) {
                $this->importLocker->unlock();
                $currentImportStatus = self::EXCHANGE_STATUS_WAITING;
            } else {
                $currentImportStatus = self::EXCHANGE_STATUS_IN_PROGRESS;
            }
            $importError = null;
        } catch (LockerException $e) {
            $currentImportStatus = self::EXCHANGE_STATUS_WAITING;
            $importError = $e->getMessage();
        }
        $importStatusData = $this->importStatusHandler->getStatus();

        return compact('currentImportStatus', 'importError', 'importStatusData');
    }

    private function getExportData()
    {
        try {
            if ($this->exportLocker->lock()) {
                $this->exportLocker->unlock();
                $currentExportStatus = self::EXCHANGE_STATUS_WAITING;
            } else {
                $currentExportStatus = self::EXCHANGE_STATUS_IN_PROGRESS;
            }
            $exportError = null;
        } catch (LockerException $e) {
            $currentExportStatus = self::EXCHANGE_STATUS_WAITING;
            $exportError = $e->getMessage();
        }
        $exportStatusData = $this->exportStatusHandler->getStatus();

        return compact('currentExportStatus', 'exportError', 'exportStatusData');
    }
}