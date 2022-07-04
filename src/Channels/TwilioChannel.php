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
        $this->client->messages->create($phoneNumber->getRouteNotification('+'), [
            'from' => $this->from,
            'body' => $content
        ]);
    }
}
