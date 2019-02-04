<?php

/**
 * @name StaticAssets
 * @desc Gestion de fichiers medias client/server.
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package presstify-plugins/static-assets
 * @version 2.0.0
 */

use tiFy\Plugins\StaticAssets\Server\ServerManager;

define('SHORTINIT', true);
require_once '../../../wp-load.php';

new ServerManager();