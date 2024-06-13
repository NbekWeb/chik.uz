<?php

return [
    'click_url' => env('CLICK_URL', 'https://my.click.uz/services/pay'),
    'min_amount' => env('CLICK_MIN_AMOUNT', 1_000_00),
    'max_amount' => env('CLICK_MAX_AMOUNT', 100_000_000_00),
    'identity' => env('CLICK_IDENTITY', 'id'),

    'click_endpoint' => env('CLICK_ENDPOINT', 'https://api.click.uz/v2/merchant/'),
    'login' => env('CLICK_USER_ID', ''),
    'service_id' => env('CLICK_SERVICE_ID', ''),
    'merchant_id' => env('CLICK_MERCHANT_ID', ''),
    'secret_key' => env('CLICK_SECRET_KEY', '')
];
