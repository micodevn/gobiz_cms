<?php
return [
    'version_script' => "20240315",
    'server' => env('CDN_SERVER', ''),
    'domain' => env('CDN_DOMAIN', ''),
    'static_domain' => env('CDN_STATIC_DOMAIN', 'https://static-k12.educa.vn'),
    'auth' => [
        'username' => env('CDN_USERNAME', ''),
        'password' => env('CDN_PASSWORD', '')
    ],
    'default_image' => '/images/image-default.jpg'
];
