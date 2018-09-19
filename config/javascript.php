<?php
return [
    'appName' => [
        'en' => env('APP_NAME'),
        'ja' => env('APP_NAME_JA'),
    ],
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'googleAnalyticsId' => env('GOOGLE_ANALYTICS_ID'),
    'googleMapsApiKey' => env('GOOGLE_API_KEY'),
];
