<?php

return [
    'default' => 'infobip',

    'providers' => [
        'infobip' => [
            'send_from' => env('INFOBIP_SEND_FROM'),

            'api_host' => env('INFOBIP_API_HOST'),

            'api_key_prefix' => env('INFOBIP_API_KEY_PREFIX'),

            'api_key' => env('INFOBIP_API_KEY'),
        ]
    ]
];
