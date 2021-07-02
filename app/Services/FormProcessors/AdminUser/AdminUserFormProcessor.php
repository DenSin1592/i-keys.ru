<?php namespace App\Services\FormProcessors\AdminUser;

use App\Services\FormProcessors\CreateUpdateFormProcessor;

/**
 * Class AdminUserFormProcessor
 * @package App\Services\FormProcessors
 */
class AdminUserFormProcessor extends CreateUpdateFormProcessor
{
    protected function prepareInputData(array $data)
    {
        if (isset($data['password']) && $data['password'] === '') {
            unset($data['password']);
        }

        if (isset($data['allowed_ips'])) {
            $data['allowed_ips'] = array_filter($data['allowed_ips'], function ($v) {
                return trim($v) !== '';
            });

        } else {
            $data['allowed_ips'] = [];
        }

        return $data;
    }
}
