<?php

return [
    'key' => env('DHLPARCEL_ID', ''),
    'secret' => env('DHLPARCEL_SECRET', ''),
    'settings' => [
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path().'/logs/dhl.log',
        'log.LogLevel' => 'ERROR',
    ],
];