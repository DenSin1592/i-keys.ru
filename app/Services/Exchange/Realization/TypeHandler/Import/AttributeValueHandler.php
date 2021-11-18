<?php

namespace App\Services\Exchange\Realization\TypeHandler\Import;

use App\Models\Attribute;
use App\Services\Exchange\DirectoryHandler\ImportDirectoryHandler;
use App\Services\Exchange\Logger\Import\AttributeValueLogger;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use App\Services\Repositories\Attribute\AllowedValue\EloquentAllowedValueRepository;
use App\Services\Exchange\Core\ITypeHandler;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use App\Services\Repositories\Product\EloquentProductRepository;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class ImportAllTypeAttributeValueHandler
 * Handler to handle attribute value import file.
 * @package App\Services\Exchange\Realization\TypeHandler
 */
class AttributeValueHandler implements ITypeHandler
{
    /** count elements in row*/
    const ELEMENTS_IN_ROW = 3;

    private $attributeRepository;
    private $allowedValueRepository;
    private $productRepository;
    private $logger;
    private $statusHandler;
    protected $csvHandlerFactory;
    protected $directoryHandler;
    protected $file;
    private $priority;

    public function __construct(
        EloquentAttributeRepository $attributeRepository,
        EloquentAllowedValueRepository $allowedValueRepository,
        EloquentProductRepository $productRepository,
        AttributeValueLogger $logger,
        ImportStatusHandler $statusHandler,
        CsvHandlerFactory $csvHandlerFactory,
        ImportDirectoryHandler $directoryHandler,
        SplFileInfo $file,
        $priority
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->allowedValueRepository = $allowedValueRepository;
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
        $attributeRelatedCategoriesIds = $this->attributeRepository->getRelatedCategoriesIdsGroupByAttributeId();

        $currentLine = 0;
        while (true) {
            $currentLine += 1;
            echo ('Обработана строка attribute value:' . $currentLine . PHP_EOL);
            $row = $csvReader->getRow();
            if ($row === false) {
                break;
            }

            $this->statusHandler->writeStatus($filePath, $currentLine);

            $rowCount = count($row);
            if ($rowCount !== self::ELEMENTS_IN_ROW) {
                $this->logger->addLog(
                    $fileName,
                    $currentLine,
                    "Необходимо " . self::ELEMENTS_IN_ROW . " полей, получено {$rowCount}"
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
            $attributeCode1c = $row[1];
            $attributeValue = $row[2];

            $errorMessage = '';
            if (empty($productCode1c)) {
                $errorMessage = "Пустое значение кода товара 1С для параметра " . $attributeCode1c . ".";
            } elseif (empty($attributeCode1c)) {
                $errorMessage = "Пустое значение кода 1С параметра для товара " . $productCode1c . ".";
            } else {
                $product = $this->productRepository->findByCode1c($productCode1c);
                if (is_null($product)) {
                    $errorMessage = "Товар с 1с кодом = " . $productCode1c . " не существует.";
                } else {
                    $attribute = $this->attributeRepository->findByCode1c($attributeCode1c);
                    if (is_null($attribute)) {
                        $errorMessage = "Параметр с 1с кодом = " . $attributeCode1c . " не существует.";
                    } else {
                        if ($attributeValue !== '') {
                            if ($attribute->attribute_type === Attribute::TYPE_SINGLE ||
                                $attribute->attribute_type === Attribute::TYPE_MULTIPLE
                            ) {
                                $allowedValue = $this->allowedValueRepository
                                    ->findForAttributeByValueOrCreate($attribute, $attributeValue);

                                if ($attribute->attribute_type === Attribute::TYPE_MULTIPLE) {
                                    $attributeValue[] = $allowedValue->id;
                                } else {
                                    $attributeValue = $allowedValue->id;
                                }
                            }
                        }

                        $this->attributeRepository->saveValue($product, $attribute, $attributeValue);
//                        $this->productRepository->markUpdateSearchForProduct($product);
                        $this->logger->solveLogs($attribute->code_1c, $product->code_1c);
                        if (!isset($attributeRelatedCategoriesIds[$attribute->id])) {
                            $attributeRelatedCategoriesIds[$attribute->id] = $attribute->categories()
                                ->get()->pluck('id')->all();
                        }
                        if (!in_array($product->category_id, $attributeRelatedCategoriesIds[$attribute->id])) {
                            $attribute->categories()->attach($product->category_id);
                            $attributeRelatedCategoriesIds[$attribute->id][] = $product->category_id;
                        }
                    }
                }
            }

            if (!empty($errorMessage)) {
                $this->logger->addLog(
                    $fileName,
                    $currentLine,
                    $errorMessage,
                    $attributeCode1c,
                    $productCode1c
                );
            }
        }
        unset($csvReader);

        if (!$this->directoryHandler->moveFileToTrash($this->file)) {
            $this->logger->addLog($fileName, null, 'Не удалось переместить файл в корзину');
        }
    }
}
