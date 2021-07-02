<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Class SessionsController
 * @package App\Http\Controllers\Admin
 */
class SessionsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return \View::make('admin.session.login', [
            'title' => 'Авторизация',
            'incorrect' => false,
            'credentials' => ['username' => '', 'password' => ''],
            'remember' => true,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $credentials = \Request::only(['username', 'password']);
        $remember = \Request::has('remember');
        if (\Auth::attempt($credentials, $remember)) {
            return \Redirect::intended(route('cc.home'));
        }

        return \View::make('admin.session.login', [
            'title' => 'Авторизация',
            'incorrect' => true,
            'credentials' => $credentials,
            'remember' => $remember,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        \Auth::logout();

        return \Redirect::route('cc.login');
    }
}
