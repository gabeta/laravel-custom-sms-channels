<?php

namespace Gabeta\CustomSmsChannels\Channels;

use Gabeta\CustomSmsChannels\Clients\LogClient;

class LogSmsChannel extends ChannelAbstract
{
    protected $client;

    protected $from;

    public function __construct(LogClient $client, $from)
    {
        $this->from = $from;
        $this->client = $client;
    }

    protected function sendMessage($phoneNumber, $content)
    {
        $this->client->write("{$phoneNumber}: {$content}");
    }
}
