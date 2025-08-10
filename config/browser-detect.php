<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
return [
    'cache' => [
        /**
         * Interval in seconds, as how long a result should be cached.
         */
        'interval' => 10080,
        /**
         * Cache prefix, the user agent string will be hashed and appended at the end.
         */
        'prefix' => 'bd4_'
    ],
    'security' => [
        /**
         * Byte length where the header is cut off, if some attacker sends a long header
         * then the library will make a cut this byte point.
         */
        'max-header-length' => 2048,
    ]
];
