<?php namespace App\Http\Controllers\Admin\Features;

trait ToggleFlags
{
    /**
     * Response for toggling a flag.
     *
     * @param $action
     * @param $modelInstance
     * @param $attribute
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function toggleFlagResponse($action, $modelInstance, $attribute)
    {
        if (\Request::ajax()) {
            $view = 'admin.shared._list_flag';
            $newFlagView = \View::make($view)
                ->with('element', $modelInstance)
                ->with('action', $action)
                ->with('attribute', $attribute)
                ->render();

            return \Response::json(['new_icon' => $newFlagView]);
        } else {
            return \Redirect::back();
        }
    }
}
