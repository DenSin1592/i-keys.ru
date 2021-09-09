<?php

namespace App\Services\Exchange\Realization\TypeHandler\Import;

use App\Models\Category;
use App\Services\Exchange\Core\ITypeHandler;
use App\Services\Exchange\DirectoryHandler\ImportDirectoryHandler;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\Logger\Import\CategoryLogger;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class CategoryHandler
 * @package App\Services\Exchange\Realization\TypeHandler\Import
 */
class CategoryHandler implements ITypeHandler
{
    /** count elements in row */
    private const ELEMENTS_IN_ROW = 3;
    private const EXTRA_ELEMENTS_IN_ROW = 2;

    private const CODE_1C_FOR_PARENT_ROOT = '19137';

    private $categoryRepository;
    private $logger;
    private $statusHandler;
    private $csvHandlerFactory;
    private $directoryHandler;
    private $file;
    private $priority;

    public function __construct(
        EloquentCategoryRepository $categoryRepository,
        CategoryLogger $logger,
        ImportStatusHandler $statusHandler,
        CsvHandlerFactory $csvHandlerFactory,
        ImportDirectoryHandler $directoryHandler,
        SplFileInfo $file,
        $priority
    ) {
        $this->categoryRepository = $categoryRepository;

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

            $categoryCode1c = $row[0];
            if ($categoryCode1c === '') {
                $this->logger->addLog(
                    $fileName,
                    $currentLine,
                    'Поле Код 1С категории пустое.'
                );
                continue;
            }

            if ($categoryCode1c == self::CODE_1C_FOR_PARENT_ROOT) {
                continue;
            }

            $data = [
                'name' => $row[1],
                'parent_id' => null,
            ];

            $parentCategoryCode1c = $row[2];
            if ($parentCategoryCode1c == $categoryCode1c) {
                $parentCategoryCode1c = '';
            }
            if ($parentCategoryCode1c !== '' && $parentCategoryCode1c != self::CODE_1C_FOR_PARENT_ROOT) {
                $parentCategory = $this->categoryRepository->findByCode1c($parentCategoryCode1c);
                if (!is_null($parentCategory)) {
                    $data['parent_id'] = $parentCategory->id;
                }
            }

            if (isset($row[3]) && $row[3] == 1) {
                $data['publish'] = false;
            }

            if (isset($row[4]) && $row[4] !== '') {
                $data['position'] = $row[4] * EloquentCategoryRepository::POSITION_STEP;
            }

            $category = $this->categoryRepository->findByCode1c($categoryCode1c);
            if (is_null($category)) {
                $data['code_1c'] = $categoryCode1c;
                $data['alias'] = $this->getUniqueAliasForCategory($data['name']);
                if (!isset($data['publish'])) {
                    $data['publish'] = true;
                }

                $category = $this->categoryRepository->create($data);
                if (is_null($category)) {
                    $this->logger->addLog(
                        $fileName,
                        $currentLine,
                        "Категорию с 1с кодом = {$categoryCode1c} не удалось создать.",
                        $categoryCode1c
                    );
                    continue;
                }
            } else {
                if (isset($data['publish']) && $data['publish'] != $category->publish) {
                    $this->logger->addLog(
                        $fileName,
                        $currentLine,
                        "Категория с 1с кодом = {$category->code_1c} " . ($data['publish'] ? 'опубликована' : 'снята с публикации') . ".",
                        $category->code_1c
                    );
                }

                $category->fill($data);
                $category->save();
            }
            $this->logger->solveLogs($category->code_1c);
        }

        unset($csvReader);

        if (!$this->directoryHandler->moveFileToTrash($this->file)) {
            $this->logger->addLog($fileName, null, 'Не удалось переместить файл в корзину');
        }
    }

    private function getUniqueAliasForCategory(string $name)
    {
        if ($name === '') {
            return null;
        }

        $i = 0;
        do {
            $alias = \Str::alias($name);
            if ($i > 0) {
                $alias .= '-' . $i;
            }
            if (Category::where('alias', $alias)->count() === 0) {
                break;
            }
            $i++;
        } while (true);

        return $alias;
    }
}
