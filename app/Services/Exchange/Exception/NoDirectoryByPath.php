<?php namespace App\Services\Exchange\Exception;


/**
 * Class NoDirectoryByPath
 * @package App\Services\Exchange\Exception
 */
class NoDirectoryByPath extends ExchangeException
{
    public function __construct($path)
    {
        parent::__construct("No directory for import by {$path}");
    }
}
