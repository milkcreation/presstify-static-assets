<?php

/**
 * @name StaticAssets
 * @desc Gestion de ressource medias client/server.
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package presstify-plugins/static-assets
 * @namespace \tiFy\Plugins\StaticAssets
 * @version 2.0.0
 */

namespace tiFy\Plugins\StaticAssets;

use tiFy\Plugins\StaticAssets\Common\CommonServiceProvider;

/**
 * Class TbSet
 * @package tiFy\Plugins\StaticAssets
 *
 * Activation :
 * ----------------------------------------------------------------------------------------------------
 * Dans config/app.php ajouter tiFy\Plugins\StaticAssets\StaticAssets à la liste des fournisseurs de services
 *     chargés automatiquement par l'application.
 * ex.
 * <?php
 * ...
 * use tiFy\Plugins\StaticAssets\StaticAssets;
 * ...
 *
 * return [
 *      ...
 *      'providers' => [
 *          ...
 *          StaticAssets::class
 *          ...
 *      ]
 * ];
 *
 * Configuration :
 * ----------------------------------------------------------------------------------------------------
 * Dans le dossier de config, créer le fichier social.php
 * @see /vendor/presstify-plugins/static-assets/Resources/config/static-assets.php Exemple de configuration.
 */
final class StaticAssets
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        container()->addServiceProvider(new CommonServiceProvider());
    }
}
