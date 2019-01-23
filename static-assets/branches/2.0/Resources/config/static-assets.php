<?php

/**
 * Exemple de configuration.
 */

return [
    'secure'       => getenv('NONCE_KEY'),
    'url'          => '',
    'base_url'     => '/assets',
    'source'       => getenv('RESOURCES_DIR') . '/medias',
    'cache'        => ABSPATH . '/wp-content/uploads/cache',
    'holder'       => 'holder.png',
    'default_path' => '/',
    'debug'        => false
];