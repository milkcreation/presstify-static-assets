<?php

namespace tiFy\Plugins\StaticAssets\Contracts;

interface ServerManager extends ServerResolver
{
    /**
     * Récupération d'une instance du conteneur d'injection ou d'un dépendance.
     *
     * @param string $alias
     *
     * @return object
     */
    public function resolve($alias, $args = []);
}