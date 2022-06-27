<?php

return [
    'default' => env('CUSTOM_SMS_CHANNEL', 'sms_log'),

    'providers' => [

        'sms_log' => [
            'config' => [
                'driver' => 'single',
                'path' => storage_path('logs/custom-sms.log'),
                'level' => 'info',
            ],

            'preview' => false,
        ],

        'infobip' => [
            'send_from' => env('INFOBIP_SEND_FROM'),

            'api_host' => env('INFOBIP_API_HOST'),

            'api_key_prefix' => env('INFOBIP_API_KEY_PREFIX'),

            'api_key' => env('INFOBIP_API_KEY'),
        ]
    ]
];
