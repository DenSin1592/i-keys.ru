<?php

namespace App\Services\Repositories\ExchangeLog;

use App\Models\ExchangeLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ExchangeLogRepository
{
    private $modelInstance;

    /**
     * ExchangeLogRepository constructor.
     */
    public function __construct()
    {
        $this->modelInstance = new ExchangeLog();
    }

    public function create(array $data)
    {
        $data['solved'] = false;

        return $this->modelInstance->create($data);
    }

    private function getUnsolvedLogsByPage(string $exchangeType, int $page, int $limit, int $daysLimit = null): array
    {
        $query = $this->modelInstance
            ->where('exchange_type', $exchangeType)
            ->where('solved', false);

        if (!is_null($daysLimit)) {
            $query->whereDate('created_at', '>=', Carbon::today()->subDays($daysLimit));
        }

        $query->orderBy('created_at', 'DESC')
            ->orderBy('type');


        $total = $query->count();
        $items = $query->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        return [
            'page' => $page,
            'limit' => $limit,
            'items' => $items,
            'total' => $total,
        ];
    }

    public function getImportUnsolvedLogsByPage(int $page, int $limit, int $daysLimit = null): array
    {
        return $this->getUnsolvedLogsByPage(ExchangeLog::EXCHANGE_TYPE_IMPORT, $page, $limit, $daysLimit);
    }

    public function getExportUnsolvedLogsByPage(int $page, int $limit, int $daysLimit = null): array
    {
        return $this->getUnsolvedLogsByPage(ExchangeLog::EXCHANGE_TYPE_EXPORT, $page, $limit, $daysLimit);
    }

    public function getUnsolvedImportLogsByType(string $type, $withNotEmptyCode1c = false): Collection
    {
        return $this->getUnsolvedLogsByType(ExchangeLog::EXCHANGE_TYPE_IMPORT, $type, $withNotEmptyCode1c);
    }

    public function getUnsolvedExportLogsByType(string $type, $withNotEmptyCode1c = true): Collection
    {
        return $this->getUnsolvedLogsByType(ExchangeLog::EXCHANGE_TYPE_EXPORT, $type, $withNotEmptyCode1c);
    }

    private function getUnsolvedLogsByType(string $exchangeType, string $type, $withNotEmptyCode1c = true): Collection
    {
        $query = $this->modelInstance->where('solved', false)
            ->where('exchange_type', $exchangeType)
            ->where('type', $type);

        if ($withNotEmptyCode1c) {
            switch ($type) {
                case ExchangeLog::TYPE_CATEGORY:
                    $query->whereNotNull('category_code_1c')
                        ->where('category_code_1c', '<>', '');
                    break;
                case ExchangeLog::TYPE_PRODUCT:
                case ExchangeLog::TYPE_PRODUCT_IMAGE:
                    $query->whereNotNull('product_code_1c')
                        ->where('product_code_1c', '<>', '');
                    break;
                case ExchangeLog::TYPE_ATTRIBUTE:
                    $query->whereNotNull('attribute_code_1c')
                        ->where('attribute_code_1c', '<>', '');
                    break;
                case ExchangeLog::TYPE_ATTRIBUTE_VALUE:
                    $query->whereNotNull('attribute_code_1c')
                        ->where('attribute_code_1c', '<>', '')
                        ->whereNotNull('product_code_1c')
                        ->where('product_code_1c', '<>', '');
                    break;
                case ExchangeLog::TYPE_CLIENT:
                    $query->whereNotNull('client_code_1c')
                        ->where('client_code_1c', '<>', '');
                    break;
                case ExchangeLog::TYPE_ORDER:
                    $query->whereNotNull('order_code_1c')
                        ->where('order_code_1c', '<>', '');
                    break;
            }
        }

        return $query->get();
    }

    public function solveImportCategoryLogs(string $code1c): int
    {
        $code1c = trim($code1c);
        if ($code1c === '') {
            return 0;
        }

        return $this->modelInstance
            ->where('exchange_type', ExchangeLog::EXCHANGE_TYPE_IMPORT)
            ->where('type', ExchangeLog::TYPE_CATEGORY)
            ->where('category_code_1c', $code1c)
            ->where('solved', false)
            ->update(['solved' => true]);
    }


    public function solveImportProductLogs(string $code1c): int
    {
        $code1c = trim($code1c);
        if ($code1c === '') {
            return 0;
        }

        return $this->modelInstance
            ->where('exchange_type', ExchangeLog::EXCHANGE_TYPE_IMPORT)
            ->where('type', ExchangeLog::TYPE_PRODUCT)
            ->where('product_code_1c', $code1c)
            ->where('solved', false)
            ->update(['solved' => true]);
    }

    public function solveImportProductImageLogs(string $code1c): int
    {
        $code1c = trim($code1c);
        if ($code1c === '') {
            return 0;
        }

        return $this->modelInstance
            ->where('exchange_type', ExchangeLog::EXCHANGE_TYPE_IMPORT)
            ->where('type', ExchangeLog::TYPE_PRODUCT_IMAGE)
            ->where('product_code_1c', $code1c)
            ->where('solved', false)
            ->update(['solved' => true]);
    }

    public function solveImportAttributeLogs(string $code1c): int
    {
        $code1c = trim($code1c);
        if ($code1c === '') {
            return 0;
        }

        return $this->modelInstance
            ->where('exchange_type', ExchangeLog::EXCHANGE_TYPE_IMPORT)
            ->where('type', ExchangeLog::TYPE_ATTRIBUTE)
            ->where('attribute_code_1c', $code1c)
            ->where('solved', false)
            ->update(['solved' => true]);
    }

    public function solveImportAttributeValueLogs(string $attributeCode1c, string $productCode1c): int
    {
        $attributeCode1c = trim($attributeCode1c);
        $productCode1c = trim($productCode1c);
        if ($attributeCode1c === '' || $productCode1c === '') {
            return 0;
        }

        return $this->modelInstance
            ->where('exchange_type', ExchangeLog::EXCHANGE_TYPE_IMPORT)
            ->where('type', ExchangeLog::TYPE_ATTRIBUTE_VALUE)
            ->where('attribute_code_1c', $attributeCode1c)
            ->where('product_code_1c', $productCode1c)
            ->where('solved', false)
            ->update(['solved' => true]);
    }

}