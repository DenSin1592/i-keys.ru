<?php

namespace App\Services\Exchange\Realization\TypeHandler\Import;

use App\Services\Exchange\Core\ITypeHandler;
use App\Services\Exchange\DirectoryHandler\ImportDirectoryHandler;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\Logger\Import\AttributeLogger;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class AttributeHandler
 * @package App\Services\Exchange\Realization\TypeHandler\Import
 */
class AttributeHandler implements ITypeHandler
{
    /** count elements in row*/
    const ELEMENTS_IN_ROW = 2;
    const EXTRA_ELEMENTS_IN_ROW = 2;

    private $attributeRepository;
    private $productRepository;
    private $logger;
    private $statusHandler;
    protected $csvHandlerFactory;
    private $directoryHandler;
    private $file;
    private $priority;

    public function __construct(
        EloquentAttributeRepository $attributeRepository,
        EloquentProductRepository $productRepository,
        AttributeLogger $logger,
        ImportStatusHandler $statusHandler,
        CsvHandlerFactory $csvHandlerFactory,
        ImportDirectoryHandler $directoryHandler,
        SplFileInfo $file,
        $priority
    ) {
        $this->attributeRepository = $attributeRepository;
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
        $this->attributeRepository->resetAllImported();
        $wasImported = false;
        while (true) {
            $currentLine += 1;
            echo ('Обработана строка attribute:' . $currentLine . PHP_EOL);
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

            // $row[2] and $row[3] are not imported
            $data = [
                'code_1c' => $row[0],
                'name' => $row[1],
            ];

            if ($data['code_1c'] === '') {
                $this->logger->addLog(
                    $fileName,
                    $currentLine,
                    "У параметра не задан код 1C."
                );
            }

            if ($data['name'] === '') {
                $this->logger->addLog(
                    $fileName,
                    $currentLine,
                    "У параметра не задано название."
                );
            }

            $attribute = $this->attributeRepository->findByCode1c($data['code_1c']);
            if (is_null($attribute)) {
                $data['attribute_type'] = $this->attributeRepository
                    ->getDefaultAttributeTypeForCode1c($data['code_1c']);
                $attribute = $this->attributeRepository->create($data);
                if (is_null($attribute)) {
                    $this->logger->addLog(
                        $fileName,
                        $currentLine,
                        "Параметр с 1с кодом = {$data['code_1c']} не удалось создать.",
                        $data['code_1c']
                    );
                    continue;
                }
            } else {
                $attribute->fill($data);
                $attribute->save();
            }

            $this->attributeRepository->markAsImportedById($attribute->id);
            $this->logger->solveLogs($attribute->code_1c);
            $wasImported |= true;
        }

        //уточнить после того, как файл появится, нужен ли ниже код
        if ($wasImported) {
            $deletedAttrData = [];
            $attributesToDelete = $this->attributeRepository->getAllNotImportedWithNotEmptyCode1c();
            foreach ($attributesToDelete as $attr) {
                $deletedAttrData[] = "{$attr->code_1c}: {$attr->name}";
                $this->productRepository->markUpdateSearchByRelatedAttribute($attr);
                $this->attributeRepository->delete($attr);
            }

            if (count($deletedAttrData) > 0) {
                $this->logger->addLog(
                    $fileName,
                    null,
                    "Были удалены параметры: " . implode(', ', $deletedAttrData) . '.'
                );
            }
        }

        unset($csvReader);

        if (!$this->directoryHandler->moveFileToTrash($this->file)) {
            $this->logger->addLog($fileName, null, 'Не удалось переместить файл в корзину');
        }
    }
}
