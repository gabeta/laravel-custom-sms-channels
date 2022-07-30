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

        $this->sendMessage($phoneNumber, $content);
    }

    /**
     * @param $notifiable
     * @return mixed
     */
    protected function getPhoneNumber($notifiable)
    {
        $methodName = "routeNotificationFor{$this->getMethodName()}";

        if (method_exists($notifiable, $methodName)) {
            $phoneNumber = $notifiable->{$methodName}();
        } elseif (method_exists($notifiable, 'routeNotificationForCustomSms')) {
            $phoneNumber = $notifiable->routeNotificationForCustomSms();
        } else {
            throw new RuntimeException(
                'enable to access to method "'.$methodName.'" or "routeNotificationForCustomSms" on '.get_class($notifiable)
            );
        }

        if (! ($phoneNumber instanceof PhoneNumber)) {
            throw new RuntimeException(
                '"'.$methodName.'" or "routeNotificationForCustomSms" must return PhoneNumber instance'
            );
        }

        return $phoneNumber;
    }

    protected function getMethodName(): string
    {
        return str_replace('Channel', '', class_basename($this));
    }

    /**
     * @param $notifiable
     * @param Notification $notification
     * @return mixed
     */
    protected function getContent($notifiable, Notification $notification)
    {
        $methodName = "to{$this->getMethodName()}";

        if (method_exists($notification, $methodName)) {
            $content = $notification->{$methodName}($notifiable);
        } elseif (method_exists($notification, 'toCustomSms')) {
            $content = $notification->toCustomSms($notifiable);
        } else {
            throw new RuntimeException(
                'enable to access to method "'.$methodName.'" or "toCustomSms" on '.get_class($notifiable)
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
