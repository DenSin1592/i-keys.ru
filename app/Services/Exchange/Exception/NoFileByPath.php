<?php namespace App\Services\Exchange\Exception;


/**
 * Class NoFileByPath
 * @package App\Services\Exchange\Exception
 */
class NoFileByPath extends ExchangeException
{
    public function __construct($path)
    {
        parent::__construct("No file for import by {$path}");
    }
}
