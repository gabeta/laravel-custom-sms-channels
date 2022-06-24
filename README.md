# Laravel custom sms channels

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gabeta/laravel-custom-sms-channels.svg?style=flat-square)](https://packagist.org/packages/gabeta/laravel-custom-sms-channels)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/gabeta/laravel-custom-sms-channels/run-tests?label=tests)](https://github.com/gabeta/laravel-custom-sms-channels/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/gabeta/laravel-custom-sms-channels/Check%20&%20fix%20styling?label=code%20style)](https://github.com/gabeta/laravel-custom-sms-channels/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/gabeta/laravel-custom-sms-channels.svg?style=flat-square)](https://packagist.org/packages/gabeta/laravel-custom-sms-channels)

Laravel notification channels package for a few SMS providers.
The specificity of this package is that you can combine several 
SMS sending services (supported by the package) in the same project 
without adding additional code.

## Installation

You can install the package via composer:

```bash
composer require gabeta/laravel-custom-sms-channels
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Gabeta\CustomSmsChannels\CustomSmsChannelsServiceProvider" --tag="config"
```

### Setting up your SMS provider

```php
    'default' => 'infobip',

    'providers' => [
        'infobip' => [
            'send_from' => env('INFOBIP_SEND_FROM'),
        
            'api_host' => env('INFOBIP_API_HOST'),
        
            'api_key_prefix' => env('INFOBIP_API_KEY_PREFIX'),
        
            'api_key' => env('INFOBIP_API_KEY'),
        ]
    ]
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;
use NotificationChannels\OneSignal\OneSignalWebButton;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    public function via($notifiable)
    {
        return ['customsms'];
    }
    
    public function toCustomSms($notifiable)
    {
        return "Hello Laravel Commuty from Ivory Coast (Côte D'ivoire)";
    }
}
```

The `customsms` channel will automatically use the provider you have defined
by default in your configuration file. It should be noted that a channel
will be created for each provider supported by the package. See the list of
channels supported.

In order to let your Notification know which user(s) phone number you are targeting,
add the `routeNotificationForCustomSms` method to your Notifiable model.
The `routeNotificationForCustomSms` method must return an instance of
`Gabeta\CustomSmsChannels\PhoneNumber`.

``` php
use Gabeta\CustomSmsChannels\Facades\PhoneNumber;

public function routeNotificationForCustomSms()
{
    return PhoneNumber::setDialCode($this->dial_code)
                ->setPhone($this->phone);
}
```

In the example above (the dial code and number are stored in separate fields)
we return an instance of `Gabeta\CustomSmsChannels\PhoneNumber` while setting
the `dial_code` without any prefix (`+` or `00`) and the phone number.
There are providers that use the dial code and number without a prefix to send SMS
others use the `+` or `00` prefix. The system will take care of the formatting according to
of each provider. If the number and dial code are stored in the same field you can
set with method.

``` php
use Gabeta\CustomSmsChannels\Facades\PhoneNumber;

public function routeNotificationForCustomSms()
{
    return PhoneNumber::setRouteNotification($this->full_phone_number);
}
```

We advise you to provide the telephone number without the prefix. As mentioned above
top the system will take care of the prefixing according to the provider.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Gabeta Soro](https://github.com/gabeta)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
