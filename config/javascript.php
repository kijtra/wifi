<?php
return [
    // 'appName' => [
    //     'en' => env('APP_NAME'),
    //     'ja' => env('APP_NAME_JA'),
    // ],
    // 'appName' => __(env('APP_NAME')),
    // 'locale' => app()->getLocale(),
    // 'locales' => config('app.locales'),
    'translate' => json_decode(file_get_contents(resource_path('lang/ja.json'))),
    'googleAnalyticsId' => env('GOOGLE_ANALYTICS_ID'),
    'googleMapsApiKey' => env('GOOGLE_API_KEY'),
];
