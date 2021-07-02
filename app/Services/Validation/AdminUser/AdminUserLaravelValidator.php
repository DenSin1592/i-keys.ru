<?php namespace App\Services\Validation\AdminUser;

use App\Services\Validation\AbstractLaravelValidator;

/**
 * Class AdminUserLaravelValidator
 * @package App\Services\Validation\AdminUser
 */
class AdminUserLaravelValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        $rules = [];
        $rules['username'] = ['required', "unique:admin_users,username,{$this->currentId}"];
        $rules['password'] = ['confirmed'];
        if (is_null($this->currentId)) {
            $rules['password'][] = 'required';
        }
        $rules['allowed_ips.*'] = ['required', 'ip'];
        $rules['admin_role_id'] = 'exists:admin_roles,id';

        return $rules;
    }



    protected function getAttributeNames()
    {
        return [
            'allowed_ips.*' => trans('validation.attributes.allowed_ips'),
        ];
    }
}
