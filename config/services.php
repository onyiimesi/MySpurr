<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],


    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_TALENT_REDIRECT_URI'),
    ],

    'message_attachment' => [
        'base_url' => env('BASE_URL_ATTACHMENT')
    ],

    'url' => [
        'production_url' => env('PRODUCTION_URL'),
        'staging_url' => env('STAGING_URL'),
        'verify_production_url' => env('VERIFY_PRODUCTION_URL'),
        'verify_staging_url' => env('VERIFY_STAGING_URL'),
        'false_production_url' => env('FALSE_PRODUCTION_URL'),
        'false_staging_url' => env('FALSE_STAGING_URL')
    ],

    'portfolio' => [
        'base_url' => env('BASE_URL_PORTFOLIO'),
        'project_image' => env('BASE_URL_PORTFOLIO_PROJECT_IMAGE')
    ],

    'imagekit' => [
        'public_key' => env('IMAGEKIT_PUBLIC_KEY'),
        'private_key' => env('IMAGEKIT_PRIVATE_KEY'),
        'endpoint_key' => env('IMAGEKIT_URL_ENDPOINT'),
    ],

    'profile' => env('BASE_URL_PROFILE'),
    'company_logo' => env('BASE_URL_COMPANY_LOGO'),
    'file' => env('BASE_URL_FILE'),
    'country_url' => env('COUNTRY_URL'),
    'country_city' => env('COUNTRY_STATE_CITY_API_KEY'),

    'base_url' => env('BASE_URL'),

];
