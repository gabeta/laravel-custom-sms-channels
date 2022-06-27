<?php

namespace Gabeta\CustomSmsChannels;

use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class CustomSmsChannelsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/custom-sms-channels.php', 'custom-sms-channels');

        if (! class_exists('GuzzleHttp\Client')) {
            throw new RuntimeException(
                'The laravel custom sms channel requires a "psr/http-client-implementation" class such as Guzzle.'
            );
        }

        $this->app->bind('CustomSmsFormatter', function () {
            return new PhoneNumber();
        });

        $this->app->bind('customsms.manager', function ($app) {
            return new CustomSmsManager($app, new Client());
        });

        $providers = array_keys($this->app['config']['custom-sms-channels']['providers']);

        foreach ($providers as $provider) {
            $this->app->singleton('providers.'.$provider, function ($app) use ($provider) {
                return $app->make('customsms.manager')->getProvider($provider);
            });

            Notification::extend($provider, function ($app) use ($provider) {
                return $app->make('customsms.manager')->getChannel($provider);
            });
        }

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('customsms', function ($app) use ($service) {
                return $service->channel($app['config']['custom-sms-channels']['default']);
            });
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/custom-sms-channels.php' => config_path('custom-sms-channels.php'),
        ], 'config');
    }
}
