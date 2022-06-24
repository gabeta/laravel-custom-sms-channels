<?php

namespace Gabeta\CustomSmsChannels;

class PhoneNumber
{
    private $routeNotification;

    private $phone;

    private $dialCode;

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function setDialCode($dialCode)
    {
        $this->dialCode = $dialCode;

        return $this;
    }

    public function setRouteNotification($routeNotification)
    {
        $this->routeNotification = $routeNotification;

        return $this;
    }

    public function getRouteNotification($prefix = null)
    {
        if (! is_null($this->routeNotification)) {
            return $prefix.$this->routeNotification;
        }

        return $prefix.$this->dialCode.$this->phone;
    }
}
