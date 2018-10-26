<?php

use Dotenv\Dotenv;

(new Dotenv(dirname(dirname(dirname(dirname(dirname(__DIR__)))))))->load();

return [
    'secure'  => getenv('NONCE_KEY'),
    'base_url'=> 'shop.pixvert.fr/static/',
    'source'  => getenv('PIXVERT_RESOURCES') . '/medias',
    'cache'   => dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/wp-content/uploads/cache',
    'holder'  => '/common/holder.png'
];