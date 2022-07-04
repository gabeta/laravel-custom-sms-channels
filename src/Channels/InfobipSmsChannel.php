<?php

namespace Gabeta\CustomSmsChannels\Channels;

use Gabeta\CustomSmsChannels\PhoneNumber;
use Infobip\Api\SendSmsApi;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;

class InfobipSmsChannel extends ChannelAbstract
{
    protected $client;

    protected $from;

    public function __construct(SendSmsApi $client, $from)
    {
        $this->from = $from;
        $this->client = $client;
    }

    public function sendMessage(PhoneNumber $phoneNumber, $content)
    {
        $destination = (new SmsDestination())->setTo($phoneNumber->getRouteNotification());

        $message = (new SmsTextualMessage())
                    ->setFrom($this->from)
                    ->setText($content)
                    ->setDestinations([$destination]);

        $request = (new SmsAdvancedTextualRequest())
                    ->setMessages([$message]);

        $this->client->sendSmsMessage($request);
    }
}
