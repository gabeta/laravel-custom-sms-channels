<?php

namespace Gabeta\CustomSmsChannels;

use Gabeta\CustomSmsChannels\Channels\InfobipSmsChannel;
use GuzzleHttp\Client;
use Infobip\Api\SendSmsApi;
use Infobip\Configuration;

class CustomSmsManager
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    protected $client;

    public function __construct($app, Client $client)
    {
        $this->app = $app;

        $this->client = $client;
    }

    public function createProviderInfobip()
    {
        $config = $this->app['config']['custom-sms-channels']['providers']['infobip'];

        $configuration = (new Configuration())
            ->setHost($config['api_host'])
            ->setApiKeyPrefix('Authorization', $config['api_key_prefix'])
            ->setApiKey('Authorization', $config['api_key']);

        return new SendSmsApi($this->client, $configuration);
    }

    public function createChannelInfobip()
    {
        return new InfobipSmsChannel(
            $this->app->make('channels.infobip'),
            $this->app['config']['custom-sms-channels.providers.infobip.send_from']
        );
    }

    public function getProvider($provider)
    {
        $config = [
            'infobip' => $this->createProviderInfobip(),
        ];

        return $config[$provider];
    }

    public function getChannel($channel)
    {
        $config = [
            'infobip' => $this->createChannelInfobip(),
        ];

        return $config[$channel];
    }
}
