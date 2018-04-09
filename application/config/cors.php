<?php

return array(

    /*
     |--------------------------------------------------------------------------
     | Laravel CORS Defaults
     |--------------------------------------------------------------------------
     |
     | The defaults are the default values applied to all the paths that match,
     | unless overridden in a specific URL configuration.
     | If you want them to apply to everything, you must define a path with *.
     |
     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*') 
     | to accept any value, the allowed methods however have to be explicitly listed.
     |
     */
    'defaults' => array(
        'supportsCredentials' => true,
        'allowedOrigins' => array('http://localhost:3000'),
        'allowedHeaders' => array('Content-Type', 'Authorization', 'Content-Range', 'Content-Disposition', 'Content-Description'),
        'allowedMethods' => array('POST', 'PUT', 'GET', 'DELETE', 'OPTIONS'),
        'exposedHeaders' => array(),
        'maxAge' => 0,
        'hosts' => array('*'),
    ),

    'paths' => array(
        'api/*' => array(
            'allowedOrigins' => array('http://localhost:3000'),
            'allowedHeaders' => array('Content-Type'),
            'allowedMethods' => array('*'),
            'maxAge' => 3600,
        ),
        '*' => array(
            'allowedOrigins' => array('http://localhost:3000'),
            'allowedHeaders' => array('Content-Type', 'Authorization', 'Content-Range', 'Content-Disposition', 'Content-Description'),
            'allowedMethods' => array('POST', 'PUT', 'GET', 'DELETE', 'OPTIONS'),
            'maxAge' => 3600,
            'hosts' => array('http://localhost:3000'),
        ),
    ),

);