<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FormProcessors\AdminUser\AdminUserFormProcessor;
use App\Services\Repositories\AdminUser\EloquentAdminUserRepository;

class AdminUsersController extends Controller
{
    /**
     * @var EloquentAdminUserRepository
     */
    private $adminUserRepository;
    /**
     * @var AdminUserFormProcessor
     */
    private $adminUserFormProcessor;

    public function __construct(
        EloquentAdminUserRepository $adminUserRepository,
        AdminUserFormProcessor $adminUserFormProcessor
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->adminUserFormProcessor = $adminUserFormProcessor;
    }

    public function index()
    {
        return \View::make('admin.admin_users.index')->with('user_list', $this->getUserList());
    }

    public function create()
    {
        return \View::make('admin.admin_users.create')
            ->with('user', $this->adminUserRepository->newInstance())
            ->with('user_list', $this->getUserList());
    }

    public function store()
    {
        $createdUser = $this->adminUserFormProcessor->create(\Request::except('redirect_to'));
        if (is_null($createdUser)) {
            return \Redirect::route('cc.admin-users.create')
                ->withErrors($this->adminUserFormProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.admin-users.index');
            } else {
                $redirect = \Redirect::route('cc.admin-users.edit', [$createdUser->id]);
            }

            return $redirect->with('alert_success', "Администратор {$createdUser->username} создан");
        }
    }

    public function edit($id)
    {
        $user = $this->adminUserRepository->find($id);
        if (is_null($user)) {
            \App::abort(404, 'Resource not found');
        }
        if ($user['super'] && !\Auth::user()->super) {
            \App::abort(403, 'Super user can be edited only by super user');
        }

        return \View::make('admin.admin_users.edit')
            ->with('user', $user)
            ->with('user_list', $this->getUserList());
    }

    public function update($id)
    {
        if (\Auth::user()->id == $id) {
            $data = \Request::except(['active', 'admin_role_id', 'redirect_to']);
        } else {
            $data = \Request::except('redirect_to');
        }

        $user = $this->adminUserRepository->find($id);
        if (is_null($user)) {
            \App::abort(404, 'Resource not found');
        }
        if ($user['super'] && !\Auth::user()->super) {
            \App::abort(403);
        }

        $updateSuccess = $this->adminUserFormProcessor->update($user, $data);
        if (!$updateSuccess) {
            return \Redirect::route('cc.admin-users.edit', [$id])
                ->withErrors($this->adminUserFormProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.admin-users.index');
            } else {
                $redirect = \Redirect::route('cc.admin-users.edit', [$id]);
            }

            return $redirect->with('alert_success', "Администратор {$user->username} обновлён");
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->id == $id) {
            \App::abort(403);
        }

        $user = $this->adminUserRepository->find($id);
        if (is_null($user)) {
            \App::abort(404, 'Resource not found');
        }
        if ($user['super'] && !\Auth::user()->super) {
            \App::abort(403);
        }

        $this->adminUserRepository->delete($user);
        return \Redirect::route('cc.admin-users.index')
            ->with('alert_success', "Администратор {$user->username} удалён");
    }

    /**
     * Get user list.
     *
     * @return \App\Models\AdminUser[]
     */
    private function getUserList()
    {
        if (\Auth::user()->super) {
            $userList = $this->adminUserRepository->all();
        } else {
            $userList = $this->adminUserRepository->allWithoutSuper();
        }

        return $userList;
    }
}
