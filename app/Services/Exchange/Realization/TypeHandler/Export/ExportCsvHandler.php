<?php

namespace App\Services\Exchange\Realization\TypeHandler\Export;

use App\Services\Exchange\Core\ITypeHandler;

abstract class ExportCsvHandler implements ITypeHandler
{
    /**
     * Generate file name
     * @param $number
     * @return string
     */
    protected function generateFileName($number): string
    {
        return sprintf("%012d_" . $this->getType() . ".csv", $number);
    }

    abstract protected function getType(): string;
}