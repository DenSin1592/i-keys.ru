<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NotFoundController extends Controller
{
    public function __invoke()
    {
        \App::abort(404, 'Unknown route');
    }
}
