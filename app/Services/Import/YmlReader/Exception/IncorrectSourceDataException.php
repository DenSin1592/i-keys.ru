<?php namespace App\Services\Import\YmlReader\Exception;

use Throwable;

/**
 * Class IncorrectSourceDataException
 * Exception about unavailable source data (no file).
 * @package App\Services\Import\YmlReader\Exception
 */
class IncorrectSourceDataException extends YmlException
{
    public function __construct($file, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Unable to open source data: {$file}", $code, $previous);
    }
}
