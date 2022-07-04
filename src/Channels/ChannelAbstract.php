<?php

namespace Gabeta\CustomSmsChannels\Channels;

use Gabeta\CustomSmsChannels\PhoneNumber;
use Illuminate\Notifications\Notification;
use RuntimeException;
use Throwable;

/**
 * Class ChannelAbstract
 * @package Gabeta\CustomSmsChannels\Channels
 */
abstract class ChannelAbstract
{
    /**
     * @param $notifiable
     * @param Notification $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $phoneNumber = $this->getPhoneNumber($notifiable);
        $content = $this->getContent($notifiable, $notification);

        try {
            $this->sendMessage($phoneNumber, $content);
        } catch (Throwable $e) {
        }
    }

    /**
     * @param $notifiable
     * @return mixed
     */
    protected function getPhoneNumber($notifiable)
    {
        if (method_exists($notifiable, 'routeNotificationForInfobip')) {
            $phoneNumber = $notifiable->routeNotificationForInfobip();
        } elseif (method_exists($notifiable, 'routeNotificationForCustomSms')) {
            $phoneNumber = $notifiable->routeNotificationForCustomSms();
        } else {
            throw new RuntimeException(
                'enable to access to method "routeNotificationForInfobip" or "routeNotificationForCustomSms" on '.get_class($notifiable)
            );
        }

        if (! ($phoneNumber instanceof PhoneNumber)) {
            throw new RuntimeException(
                '"routeNotificationForInfobip" or "routeNotificationForCustomSms" must return PhoneNumber instance'
            );
        }

        return $phoneNumber;
    }

    /**
     * @param $notifiable
     * @param Notification $notification
     * @return mixed
     */
    protected function getContent($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toInfobip')) {
            $content = $notification->toInfobip($notifiable);
        } elseif (method_exists($notification, 'toCustomSms')) {
            $content = $notification->toCustomSms($notifiable);
        } else {
            throw new RuntimeException(
                'enable to access to method "toInfobip" or "toCustomSms" on '.get_class($notifiable)
            );
        }

        return $content;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @param $content
     * @return mixed
     */
    abstract protected function sendMessage(PhoneNumber $phoneNumber, $content);
}
