<?php

return [
    'transport' => 'gmail',
    'from_address' => env('GMAIL_FROM_ADDRESS'),
    'service_account_key' => env('GMAIL_SERVICE_ACCOUNT_KEY'),
];