<?php namespace App\Services\Exchange\Exception;

/**
 * Class CannotCopyFile
 * @package App\Services\Exchange\Exception
 */
class CannotCopyFile extends ExchangeException
{
    public function __construct($file, $to)
    {
        parent::__construct("Can not copy file {$file} to {$to}");
    }
}
