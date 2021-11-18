<?php

namespace App\Services\Exchange\Realization\TypeHandler\Import;

use App\Services\Exchange\Core\ITypeHandler;
use App\Services\Exchange\DirectoryHandler\ImportImagesDirectory\ImportProductImagesDirectory;
use App\Services\Exchange\Logger\Import\ProductImageLogger;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Repositories\ProductImage\EloquentProductImageRepository;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class ProductImageHandler
 * @package App\Services\Exchange\Realization\TypeHandler\Import
 */
class ProductImageHandler implements ITypeHandler
{
    private $productRepository;
    private $productImageRepository;
    private $logger;
    private $directoryHandler;

    /**
     * ProductImageHandler constructor.
     * @param EloquentProductRepository $productRepository
     * @param EloquentProductImageRepository $productImageRepository
     * @param ProductImageLogger $logger
     * @param ImportProductImagesDirectory $directoryHandler
     */
    public function __construct(
        EloquentProductRepository $productRepository,
        EloquentProductImageRepository $productImageRepository,
        ProductImageLogger $logger,
        ImportProductImagesDirectory $directoryHandler
    ) {
        $this->productRepository = $productRepository;
        $this->productImageRepository = $productImageRepository;
        $this->logger = $logger;
        $this->directoryHandler = $directoryHandler;
    }

    /**
     * Get priority of this handler.
     * @return int
     */
    public function getPriority()
    {
        return 100;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $productsByCodes = [];
        $files = $this->directoryHandler->getFilesForImport();
        $currentLine =0;
        foreach ($files as $file) {
            $currentLine += 1;
            echo ('Обработана картинка:' . $currentLine . PHP_EOL);
            $fileName = $file->getFilename();
            if (!preg_match("/^product_(?P<code_1c>[^_]+)_(?P<number>\d+)\./", $fileName, $matches)) {
                continue;
            }
            $code1c = trim($matches['code_1c']);
            if (empty($code1c)) {
                continue;
            }

            $filePath = $file->getRealPath();
            if (!$this->imageValidator($file)->passes()) {
                continue;
            }

            if (isset($productsByCodes[$code1c])) {
                $product = $productsByCodes[$code1c];
            } else {
                $product = $this->productRepository->findByCode1c($code1c);
                if (is_null($product)) {
                    continue;
                }
                $productsByCodes[$product->code_1c] = $product;
            }

            $number = (int)$matches['number'];

            $data = [
                'image_file' => $filePath,
                'position' => $number * 10,
                'publish' => true,
                'number' => $number
            ];

            $productImage = $this->productImageRepository->createOrUpdateForProductByNumber($product, $data);
            if (is_null($productImage)) {
                $this->logger->addLog($fileName, 'Не удалось импортировать изображение', $product->code_1c);
                continue;
            }

            if (!$this->directoryHandler->moveFileToTrash($file)) {
                $this->logger->addLog(
                    $fileName,
                    'Не удалось переместить файл в корзину для изображений',
                    $product->code_1c
                );
            }
        }
    }

    /**
     * @param SplFileInfo $file
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function imageValidator(SplFileInfo $file)
    {
        return \Validator::make(
            [
                'image_file' => $file->getRealPath(),
                'file_size' => $file->getSize(),
            ],
            [
                'image_file' => ['required', 'stored_file:jpeg,jpg,png,gif,JPEG,JPG,PNG,GIF'],
                'file_size' => ['required', 'numeric', 'min:1'],
            ]
        );
    }
}
