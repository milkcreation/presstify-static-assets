<?php

namespace tiFy\Plugins\StaticAssets\Server;

use League\Container\Container as LeagueContainer;

class Container extends LeagueContainer
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->addServiceProvider(new ServiceProvider());

        $this->get('img');
    }
}