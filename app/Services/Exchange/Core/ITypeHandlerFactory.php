<?php

namespace App\Services\Exchange\Core;

/**
 * Interface ITypeHandlerFactory
 * Factory to create list of appropriate handlers.
 * @package App\Services\Exchange\Core
 */
interface ITypeHandlerFactory
{
    /**
     * Get list of handlers.
     * @return ITypeHandler[]
     */
    public function getTypeHandlerList();


    /**
     * Get type priority
     * @return int
     */
    public function getTypePriority();
}
