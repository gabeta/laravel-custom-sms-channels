<?php


namespace Gabeta\CustomSmsChannels\Channels;


use Gabeta\CustomSmsChannels\PhoneNumber;
use Twilio\Rest\Client;

class TwilioChannel extends ChannelAbstract
{
    private $client;

    private $from;

    public function __construct(Client $client, $from)
    {
        $this->client = $client;
        $this->from = $from;
    }

    /**
     * @inheritDoc
     */
    protected function sendMessage(PhoneNumber $phoneNumber, $content)
    {
        $options = [
            'from' => $this->from,
            'body' => $content
        ];

        if (config('custom-sms-channels.providers.twilio.status_callback')) {
            $options['statusCallback'] = config('custom-sms-channels.providers.twilio.status_callback');
        }

        $this->client->messages->create($phoneNumber->getRouteNotification('+'), $options);
    }
}
