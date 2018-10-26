<?php

/**
 * @name StaticAssets
 * @desc Gestion de fichiers medias client/server.
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package presstify-plugins/static-assets
 * @version 2.0.0
 */

use Composer\Autoload\ClassLoader;
use tiFy\Plugins\StaticAssets\Server\Container;

/** Deboggage */
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (file_exists('../../autoload.php')) :
    include ('../../autoload.php');
    $loader = new ClassLoader();
    $loader->addPsr4('tiFy\Plugins\StaticAssets\\', __DIR__ . '/');
    $loader->register();

    new Container();
endif;


