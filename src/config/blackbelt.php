<?php

declare(strict_types=1);

return [
    'client_id'         => env('BLACKBELT_CLIENt_ID', null),
    'client_secret'     => env('BLACKBELT_CLIENT_SECRET', null),
    'timeout'           => env('BLACKBELT_CLIENT_TIMEOUT', 5.0),
];
