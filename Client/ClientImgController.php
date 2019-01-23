<?php

namespace tiFy\Plugins\StaticAssets\Client;

class ClientImgController extends ClientController
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct($path)
    {
        parent::__construct($path, 'img');
    }
}