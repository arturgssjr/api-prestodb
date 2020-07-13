<?php

return [
    'presto' => [
        'driver' => env('PRESTO_CONNECTION', 'presto'),
        'host' => env('PRESTO_HOST', 'localhost'),
        'port' => env('PRESTO_PORT', '8080'),
        'catalog' => env('PRESTO_CATALOG', ''),
        'schema' => env('PRESTO_SCHEMA', ''),
    ],
];
