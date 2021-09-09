<?php

namespace App\Services\Exchange\Core;

/**
 * Interface ITypeHandler
 * Handler for some piece of data.
 * @package App\Services\Exchange\Core
 */
interface ITypeHandler
{
    /**
     * Get priority of this handler.
     * @return int
     */
    public function getPriority();

    /**
     * Handle the data
     * @return void
     */
    public function handle();
}
