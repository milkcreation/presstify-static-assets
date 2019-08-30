<?php

namespace tiFy\Plugins\StaticAssets\Client;

class ClientImgController extends ClientController
{
    /**
     * CONSTRUCTEUR.
     *
     * @param string $path Chemin relatif vers le repertoire des ressources.
     *
     * @return void
     */
    public function __construct($path)
    {
        parent::__construct($path, 'img');
    }
}