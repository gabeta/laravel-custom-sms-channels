<?php

namespace Gabeta\CustomSmsChannels\Channels;

use Gabeta\CustomSmsChannels\Clients\LogClient;
use Gabeta\CustomSmsChannels\PhoneNumber;

/**
 * Class LogSmsChannel
 * @package Gabeta\CustomSmsChannels\Channels
 */
class LogSmsChannel extends ChannelAbstract
{
    /**
     * @var LogClient
     */
    protected $client;

    /**
     * @var $from
     */
    protected $from;

    /**
     * LogSmsChannel constructor.
     *
     * @param LogClient $client
     * @param $from
     */
    public function __construct(LogClient $client, $from)
    {
        $this->from = $from;
        $this->client = $client;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @param $content
     */
    protected function sendMessage(PhoneNumber $phoneNumber, $content)
    {
        $this->client->write("{$phoneNumber->getRouteNotification()}: {$content}");
    }
}
