<?php

return [
    'cache_method' => env('REDIRECTOR_CACHE_METHOD', 'multiple'), // Options: 'multiple', 'single'
    'cache_ttl' => env('REDIRECTOR_CACHE_TTL', 60 * 60 * 24), // TTL in seconds
];
