<?php

namespace Gabeta\CustomSmsChannels;

use Gabeta\CustomSmsChannels\Channels\InfobipSmsChannel;
use Gabeta\CustomSmsChannels\Channels\LogSmsChannel;
use Gabeta\CustomSmsChannels\Channels\TwilioChannel;
use Gabeta\CustomSmsChannels\Clients\LogClient;
use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\LogManager;
use Infobip\Api\SendSmsApi;
use Infobip\Configuration;
use InvalidArgumentException;

class CustomSmsManager
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    protected $client;

    public function __construct(Application $app, Client $client)
    {
        $this->app = $app;

        $this->client = $client;
    }

    public function getProvider($provider)
    {
        $providerMethod = 'createProvider'.str_replace('_', '', ucwords(ucfirst($provider), '_'));

        if (! method_exists($this, $providerMethod)) {
            throw new InvalidArgumentException("Provider [{$provider}] is not supported.");
        }

        return $this->{$providerMethod}();
    }

    public function getChannel($provider)
    {
        $channelMethod = 'createChannel'.str_replace('_', '', ucwords(ucfirst($provider), '_'));

        if (! method_exists($this, $channelMethod)) {
            throw new InvalidArgumentException("Provider [{$provider}] is not supported.");
        }

        return $this->{$channelMethod}();
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
            $this->app->make('providers.infobip'),
            $this->app['config']['custom-sms-channels.providers.infobip.send_from']
        );
    }

    public function createProviderSmsLog()
    {
        return new LogClient(
            $this->app->make(LogManager::class),
            $this->app['config']['custom-sms-channels.providers.sms_log.config']
        );
    }

    public function createChannelSmsLog()
    {
        return new LogSmsChannel(
            $this->app->make('providers.sms_log'),
            $this->app['config']['app']['name']
        );
    }

    public function createProviderTwilio()
    {
        $config = $this->app['config']['custom-sms-channels']['providers']['twilio'];

        return new \Twilio\Rest\Client(
            $config['sid'],
            $config['auth_token']
        );
    }

    public function createChannelTwilio()
    {
        return new TwilioChannel(
            $this->app->make('providers.twilio'),
            $this->app['config']['custom-sms-channels.providers.twilio.number']
        );
    }
}
