<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cache Method
    |--------------------------------------------------------------------------
    |
    | This option controls the caching method for storing the redirect rules.
    | You can choose between two methods: 'full_list' and 'single'.
    |
    | 'full_list': All active redirects are cached as a single collection.
    | This is efficient for a small number of redirects but may become
    | inefficient as the number of redirects grows.
    |
    | 'single': Each redirect is cached individually. This method scales
    | better with a large number of redirects but may result in more cache
    | operations.
    |
    | Options: 'full_list', 'single'
    |
    */
    'cache_method' => env('REDIRECTOR_CACHE_METHOD', 'full_list'), // Options: 'full_list', 'single'

    /*
    |--------------------------------------------------------------------------
    | Cache TTL
    |--------------------------------------------------------------------------
    |
    | This option controls the time-to-live (TTL) for the cache entries,
    | specified in seconds. This determines how long the redirect rules
    | will be cached before they are fetched again from the database.
    |
    | Example: 60 * 60 * 24 = 24 hours
    |
    */
    'cache_ttl' => env('REDIRECTOR_CACHE_TTL', 60 * 60 * 24),
];
