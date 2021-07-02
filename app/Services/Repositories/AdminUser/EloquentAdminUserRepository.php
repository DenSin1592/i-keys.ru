<?php namespace App\Services\Repositories\AdminUser;

use App\Models\AdminUser;

/**
 * Class EloquentAdminUserRepository
 * @package App\Services\Repositories\AdminUser
 */
class EloquentAdminUserRepository
{
    public function all()
    {
        return AdminUser::orderBy('username')->get();
    }


    public function allWithoutSuper()
    {
        return AdminUser::orderBy('username')->where('super', false)->get();
    }


    public function newInstance(array $data = [])
    {
        return new AdminUser($data);
    }


    public function find($id)
    {
        return AdminUser::find($id);
    }


    public function create(array $data)
    {
        return AdminUser::create($data);
    }


    public function update(AdminUser $adminUser, array $data)
    {
        return $adminUser->update($data);
    }


    public function delete(AdminUser $adminUser)
    {
        return $adminUser->delete();
    }
}
