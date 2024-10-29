<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cors extends BaseConfig
{
    public array $default = [
        /**
         * Origins for the `Access-Control-Allow-Origin` header.
         */
        'allowedOrigins' => [],

        /**
         * Origin regex patterns for the `Access-Control-Allow-Origin` header.
         */
        'allowedOriginsPatterns' => [],

        /**
         * Weather to send the `Access-Control-Allow-Credentials` header.
         */
        'supportsCredentials' => false,

        /**
         * Set headers to allow.
         */
        'allowedHeaders' => ['Authorization', 'Content-Type', 'api_key'],

        /**
         * Set headers to expose.
         * Ini opsional, tambahkan jika kamu perlu mengekspos header di respons.
         */
        'exposedHeaders' => ['api_key'],

        /**
         * Set methods to allow.
         */
        'allowedMethods' => ['GET', 'POST', 'PUT', 'DELETE'],

        /**
         * Set how many seconds the results of a preflight request can be cached.
         */
        'maxAge' => 7200,
    ];
}
