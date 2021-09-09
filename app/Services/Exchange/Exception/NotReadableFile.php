<?php namespace App\Services\Exchange\Exception;


/**
 * Class NotReadableFile
 * @package App\Services\Import\Importer\Exception
 */
class NotReadableFile extends ExchangeException
{
    public function __construct($file)
    {
        parent::__construct("File {$file} is not readable");
    }
}

