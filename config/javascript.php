<?php

return [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'googleAnalyticsId' => env('GOOGLE_ANALYTICS_ID'),
    'googleMapsApiKey' => env('GOOGLE_API_KEY'),
];
