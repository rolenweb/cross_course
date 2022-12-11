<?php

return [
    'base_currency' => env('CROSS_COURSE_BASE_CURRENCY', 'RUB'),
    'provider' => env('CROSS_COURSE_PROVIDER', 'crb'),
    'providers' => [
        'crb' => [
            'handler' => \Source\CrossCourses\Crb\Crb::class,
            'source' => [
                'url' => 'https://cbr.ru/currency_base/daily/?UniDbQuery.Posted=True&UniDbQuery.To='
            ]
        ]
    ]
];
