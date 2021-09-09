<?php

namespace App\Services\Exchange\DirectoryHandler;

use File;
use Symfony\Component\Finder\SplFileInfo;

class ImportImagesDirectoryHandler extends ImportDirectoryHandler
{
    /**
     * @param SplFileInfo $file
     * @return bool
     */
    public function moveFileToTrash(SplFileInfo $file): bool
    {
        $newFileName = date('YmdHis') . '_' . $file->getFilename();

        return File::move($file->getRealPath(), $this->importTrashDir . DIRECTORY_SEPARATOR . $newFileName);
    }
}