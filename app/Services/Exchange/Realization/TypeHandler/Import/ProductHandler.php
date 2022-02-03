<?php

namespace App\Services\Exchange\Realization\TypeHandler\Import;

use App\Models\Product;
use App\Services\Exchange\Core\ITypeHandler;
use App\Services\Exchange\DirectoryHandler\ImportDirectoryHandler;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\Logger\Import\ProductLogger;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class ProductHandler
 * @package App\Services\Exchange\Realization\TypeHandler\Import
 */
class ProductHandler implements ITypeHandler
{
    /** count elements in row */
    const ELEMENTS_IN_ROW = 5;
    const EXTRA_ELEMENTS_IN_ROW = 1;

    private $categoryRepository;
    private $productRepository;
    private $logger;
    private $statusHandler;
    protected $csvHandlerFactory;
    private $directoryHandler;
    private $file;
    private $priority;

    public function __construct(
        EloquentCategoryRepository $categoryRepository,
        EloquentProductRepository $productRepository,
        ProductLogger $logger,
        ImportStatusHandler $statusHandler,
        CsvHandlerFactory $csvHandlerFactory,
        ImportDirectoryHandler $directoryHandler,
        SplFileInfo $file,
        $priority
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;

        $this->logger = $logger;
        $this->statusHandler = $statusHandler;
        $this->csvHandlerFactory = $csvHandlerFactory;
        $this->directoryHandler = $directoryHandler;
        $this->file = $file;
        $this->priority = $priority;
    }

    /**
     * @inheritDoc
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $filePath = $this->file->getRealPath();
        $fileName = $this->file->getFilename();
        $csvReader = $this->csvHandlerFactory->getReaderFor($filePath);
        $currentLine = 0;
        while (true) {
            $currentLine += 1;
            echo ('Обработана строка продукта:' . $currentLine . PHP_EOL);
            $row = $csvReader->getRow();
            if ($row === false) {
                break;
            }

            $this->statusHandler->writeStatus($filePath, $currentLine);

            $rowCount = count($row);
            if ($rowCount < self::ELEMENTS_IN_ROW || $rowCount > (self::ELEMENTS_IN_ROW + self::EXTRA_ELEMENTS_IN_ROW)) {
                $this->logger->addLog(
                    $fileName,
                    $currentLine,
                    "Необходимо " . self::ELEMENTS_IN_ROW . "-" . (self::ELEMENTS_IN_ROW + self::EXTRA_ELEMENTS_IN_ROW) . " полей, получено {$rowCount}"
                );
                continue;
            }

            $row = array_map(
                function ($value) {
                    return trim($value);
                },
                $row
            );

            $productCode1c = $row[0];
            if ($productCode1c === '') {
                $this->logger->addLog(
                    $fileName,
                    $currentLine,
                    'Поле Код 1С товара пустое.'
                );
                continue;
            }


            $productName =  $row[1];
            if ($productName === '') {
                $this->logger->addLog(
                    $fileName,
                    $currentLine,
                    "Товар с кодом 1C {$productCode1c} не был импортирован, т.к. поле Название категории пустое.",
                );
                continue;
            }


            $categoryCode1c = $row[3];
            if ($categoryCode1c === '') {
                $this->logger->addLog(
                    $fileName,
                    $currentLine,
                    "Товар с кодом 1C {$productCode1c} не был импортирован, т.к. поле Код 1С категории пустое.",
                    $productCode1c
                );
                continue;
            }
            $category = $this->categoryRepository->findByCode1c($categoryCode1c);
            if (is_null($category)) {
                $this->logger->addLog(
                    $fileName,
                    $currentLine,
                    "Товар с кодом 1C {$productCode1c} не был импортирован, т.к. категории с кодом 1с {$categoryCode1c} не существует.",
                    $productCode1c
                );
                continue;
            }

            $description = str_replace(['<pre>', '</pre>'], '', $row[4]);
            $description = nl2br($description);
            $price = str_replace(',', '.', $row[2]);
            if (empty($price)) {
                $price = null;
            } else {
                $price = (float)$price;
            }

            $productData = [
                'code_1c' => $productCode1c,
                'name' => $row[1],
                'price' => $price,
                'description' => $description,
                'category_id' => $category->id,
            ];

            if (isset($row[5]) && $row[5] == 1) {
                $productData['publish'] = false;
            }

            /** @var Product $product */
            $product = $this->productRepository->findByCode1C($productData['code_1c']);
            if (is_null($product)) {
                if (!isset($productData['publish'])) {
                    $productData['publish'] = true;
                }

                $product = $this->productRepository->create($productData);
                if (is_null($product)) {
                    $this->logger->addLog(
                        $fileName,
                        $currentLine,
                        "Товар с 1с кодом = {$productData['code_1c']} не удалось создать.",
                        $productData['code_1c']
                    );
                    continue;
                }
            } else {
                if (isset($productData['publish']) && $productData['publish'] != $product->publish) {
                    $this->logger->addLog(
                        $fileName,
                        $currentLine,
                        "Товар с 1с кодом = {$productData['code_1c']} " . ($productData['publish'] ? 'опубликован' : 'снят с публикации') . ".",
                        $productData['code_1c']
                    );
                }

                $product->fill($productData);
                $product->save();
            }

            $this->productRepository->markUpdateSearchForProduct($product);
            $this->logger->solveLogs($product->code_1c);
        }

        unset($csvReader);

        if (!$this->directoryHandler->moveFileToTrash($this->file)) {
            $this->logger->addLog($fileName, null, 'Не удалось переместить файл в корзину');
        }
    }
}
