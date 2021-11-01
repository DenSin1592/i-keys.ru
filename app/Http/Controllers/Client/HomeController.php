<?php namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('client.home_page.show');
    }
}
