<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Ensure API routes are included

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:3003'], // Add all required origins

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // Keep this true if using authentication
];

