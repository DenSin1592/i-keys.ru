<?php namespace App\Services\Device;

class DeviceHelper
{
    const DEVICE_TYPE_PHONE = 'phone';
    const DEVICE_TYPE_TABLET = 'tablet';
    const DEVICE_TYPE_DESKTOP = 'desktop';

    private $agent;
    private $deviceType;

    public function __construct(\Mobile_Detect $agent)
    {
        $this->agent = $agent;
        $this->init();
    }

    /**
     * Check if the device is any type of mobile device (phone, tablet)
     *
     * @return bool
     */
    public function isMobile()
    {
        return  $this->agent->isMobile();
    }

    /**
     * Check if the device is a tablet
     *
     * @return bool
     */
    public function isTablet()
    {
        return $this->agent->isTablet();
    }

    /**
     * Check if the device is a phone
     *
     * @return bool
     */
    public function isPhone()
    {
        return $this->isMobile() && ! $this->isTablet();
    }

    public function getDeviceType()
    {
        return $this->deviceType;
    }

    private function init()
    {
        if (!$this->isMobile()) {
            $this->deviceType = self::DEVICE_TYPE_DESKTOP;
        } elseif($this->isTablet()) {
            $this->deviceType = self::DEVICE_TYPE_TABLET;
        } else {
            $this->deviceType = self::DEVICE_TYPE_PHONE;
        }
    }
}