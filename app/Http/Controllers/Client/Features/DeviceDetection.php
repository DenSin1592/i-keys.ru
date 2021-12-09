<?php namespace App\Http\Controllers\Client\Features;

trait DeviceDetection
{
    protected function addDeviceInfo(array $data)
    {
        if (!isset($data['user_agent'])) {
            $data['user_agent'] = \Request::server('HTTP_USER_AGENT');
        }

        if (!isset($data['device_type'])) {
            $data['device_type'] = \DeviceHelper::getDeviceType();
        }

        return $data;
    }
}