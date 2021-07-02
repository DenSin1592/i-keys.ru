<?php namespace App\Services\Composers;

/**
 * Class CurrentAdminUserComposer
 * @package App\Services\Composers
 */
class CurrentAdminUserComposer
{
    public function compose($view)
    {
        $view->with('currentAdminUser', \Auth::user());
    }
}
