<?php namespace App\Services\Exchange\Exception;

/**
 * Class CannotCreateDirectoryByPath
 * @package App\Services\Exchange\Exception
 */
class CannotCreateDirectoryByPath extends ExchangeException
{
    public function __construct($path)
    {
        parent::__construct("Can not create directory {$path}");
    }
}
