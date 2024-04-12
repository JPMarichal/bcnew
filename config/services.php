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
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        'chat_id' => env('TELEGRAM_CHAT_ID'),
    ],
    'pinterest' => [
        'access_token' => env('PINTEREST_ACCESS_TOKEN'),
        'board_id' => env('PINTEREST_BOARD_ID'),
    ],
    'twitter' => [
        'api_key' => env('TWITTER_API_KEY'),
        'api_secret_key' => env('TWITTER_API_SECRET_KEY'),
        'access_token' => env('TWITTER_ACCESS_TOKEN'),
        'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),
    ],
    'facebook' => [
        'facebook_app_id' => env('FACEBOOK_APP_ID'),
        'facebook_app_secret' => env('FACEBOOK_APP_SECRET'),
        'facebook_page_access_token' => env('FACEBOOK_PAGE_ACCESS_TOKEN'),
        'facebook_group_access_token' =>  env('FACEBOOK_GROUP_ACCESS_TOKEN')
    ],
    'messenger' => [
        'access_token' => env('MESSENGER_ACCESS_TOKEN'),
    ],
];
