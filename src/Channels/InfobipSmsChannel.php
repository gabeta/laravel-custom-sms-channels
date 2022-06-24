<?php

namespace Gabeta\CustomSmsChannels\Channels;

use Gabeta\CustomSmsChannels\PhoneNumber;
use Illuminate\Notifications\Notification;
use Infobip\Api\SendSmsApi;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use RuntimeException;
use Throwable;

class InfobipSmsChannel
{
    private $client;

    private $from;

    public function __construct(SendSmsApi $client, $from)
    {
        $this->from = $from;
        $this->client = $client;
    }

    public function send($notifiable, Notification $notification)
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

        if (method_exists($notification, 'toInfobip')) {
            $content = $notification->toInfobip($notifiable);
        } elseif (method_exists($notification, 'toCustomSms')) {
            $content = $notification->toCustomSms($notifiable);
        } else {
            throw new RuntimeException(
                'enable to access to method "toInfobip" or "toCustomSms" on '.get_class($notifiable)
            );
        }

        $destination = (new SmsDestination())->setTo($phoneNumber->getRouteNotification());

        $message = (new SmsTextualMessage())
                    ->setFrom($this->from)
                    ->setText($content)
                    ->setDestinations([$destination]);

        $request = (new SmsAdvancedTextualRequest())
                    ->setMessages([$message]);

        try {
            $this->client->sendSmsMessage($request);

            dd($phoneNumber->getRouteNotification());
        } catch (Throwable $e) {
            dd($e);
        }
    }
}
