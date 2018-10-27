<?php

/**
 * Exemple de configuration.
 */

return [
    'secure'       => getenv('NONCE_KEY'),
    'url'          => '',
    'base_url'     => '/assets',
    'source'       => getenv('PIXVERT_RESOURCES') . '/medias',
    'cache'        => ABSPATH . '/wp-content/uploads/cache',
    'holder'       => '/common/holder.png',
    'default_path' => '/common',
    'debug'        => false
];