<?php

namespace Gabeta\CustomSmsChannels;

use Gabeta\CustomSmsChannels\Http\Controllers\PreviewDashboardController;
use Gabeta\CustomSmsChannels\Http\Controllers\SmsListController;
use GuzzleHttp\Client;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
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

        $this->configureRoutes();

        $this->configureChannels();
    }

    protected function configureChannels()
    {
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

    protected function configureRoutes()
    {
        $preview = config('custom-sms-channels.preview.enable');

        if ($preview) {
            Route::group([
                'domain' => config('custom-sms-channels.preview.domain'),
                'prefix' => config('custom-sms-channels.preview.path'),
            ], function () {
                Route::get('/', PreviewDashboardController::class)->name('customsms.dashboard');
                Route::get('/ajax-sms', SmsListController::class)->name('customsms.sms-list');
            });
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'customsms');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/custom-sms-channels.php' => config_path('custom-sms-channels.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/.../resources/assets' => public_path('vendor/customsms'),
            ], 'public');
        }
    }
}
