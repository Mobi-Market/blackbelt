<?php

declare(strict_types=1);

return [
    'client_id'         => env('BLACKBELT_CLIENT_ID', ''),
    'client_secret'     => env('BLACKBELT_CLIENT_SECRET', ''),
    'timeout'           => env('BLACKBELT_CLIENT_TIMEOUT', 5.0),
];
